<?php

namespace Municipal\Attestation\Support;

use Illuminate\Support\Facades\DB;

class MemoGenerator
{
    /**
     * Generate a concurrency-safe sequential memo number for a type + year.
     *
     * @return array{memo_no: string, year: int, serial: int}
     */
    public static function next(int $typeId, string $memoName, ?int $year = null): array
    {
        $year = $year ?? (int) now()->format('Y');
        $result = ['memo_no' => '', 'year' => $year, 'serial' => 1];

        DB::transaction(function () use ($typeId, $year, $memoName, &$result) {
            $sequence = DB::table('attestation_sequences')
                ->where('attestation_type_id', $typeId)
                ->where('year', $year)
                ->lockForUpdate()
                ->first();

            $serialPad = (int) config('attestation.memo.serial_pad', 2);

            if ($sequence) {
                $newSeq = ((int) $sequence->last_number) + 1;
                DB::table('attestation_sequences')
                    ->where('id', $sequence->id)
                    ->update([
                        'last_number' => $newSeq,
                        'updated_at'  => now(),
                    ]);
            } else {
                $newSeq = 1;
                DB::table('attestation_sequences')->insert([
                    'attestation_type_id' => $typeId,
                    'year'                => $year,
                    'last_number'         => $newSeq,
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ]);
            }

            $seqFormatted = str_pad((string) $newSeq, $serialPad, '0', STR_PAD_LEFT);
            $isEnglish    = (bool) preg_match('/^[A-Za-z0-9\s\-\/\(\)\.]+$/', $memoName);

            if ($isEnglish) {
                $memoString = "A:P:/{$memoName}/{$year}/{$seqFormatted}";
            } else {
                $bengaliYear = BengaliHelper::toBengaliDigits($year);
                $bengaliSeq  = BengaliHelper::toBengaliDigits($seqFormatted);
                $prefix      = config('attestation.organization.short_name', 'আঃপৌঃ');
                $memoString  = "{$prefix}/{$memoName}/{$bengaliYear}/{$bengaliSeq}";
            }

            $result = [
                'memo_no' => $memoString,
                'year'    => $year,
                'serial'  => $newSeq,
            ];
        });

        return $result;
    }

    public static function generate(int $typeId, string $memoName, int $year): string
    {
        return static::next($typeId, $memoName, $year)['memo_no'];
    }
}
