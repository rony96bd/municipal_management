<?php

use Illuminate\Database\Migrations\Migration;
use Municipal\Attestation\Models\AttestationType;

return new class extends Migration
{
    public function up(): void
    {
        $types = AttestationType::where('slug', 'paribarik-sonod')
            ->orWhere('name', 'পারিবারিক সনদ পত্র')
            ->get();

        foreach ($types as $type) {
            $type->signatories = [
                ['preset_key' => 'D1', 'label' => 'প্রস্তুতকারী'],
                ['preset_key' => 'C1', 'label' => 'যাচাইকারী'],
                ['preset_key' => 'D3', 'label' => 'অনুমোদনকারী কর্মকর্তা'],
            ];
            $type->save();
        }
    }

    public function down(): void
    {
    }
};
