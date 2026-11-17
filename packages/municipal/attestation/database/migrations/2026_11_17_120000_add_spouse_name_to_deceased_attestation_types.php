<?php

use Illuminate\Database\Migrations\Migration;
use Municipal\Attestation\Models\AttestationType;

return new class extends Migration
{
    public function up(): void
    {
        $types = AttestationType::all();
        foreach ($types as $type) {
            $pf = $type->person_fields ?: [];
            if (in_array('father_name', $pf) && !in_array('spouse_name', $pf)) {
                $newPf = [];
                foreach ($pf as $f) {
                    $newPf[] = $f;
                    if ($f === 'father_name') {
                        $newPf[] = 'spouse_name';
                    }
                }
                $type->person_fields = $newPf;
                $type->save();
            }
        }
    }

    public function down(): void
    {
        // Keep updated person_fields
    }
};
