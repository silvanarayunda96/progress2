<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'nama_depan' => ['required', 'string', 'max:255'],
            'nama_belakang' => ['required', 'string', 'max:255'],
            'nomor_identitas' => ['required', 'string', 'max:50'], // sesuaikan jika perlu
            'nomor_handphone' => ['required', 'string', 'max:20'], // sesuaikan jika perlu
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            // Jika ada terms & privacy policy
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'nama_depan' => $input['nama_depan'],
            'nama_belakang' => $input['nama_belakang'],
            'nomor_identitas' => $input['nomor_identitas'],
            'nomor_handphone' => $input['nomor_handphone'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
