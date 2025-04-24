<?php

    namespace App\Http\Requests\Admin;

    use App\Platform\Classes\Users\Roles;
    use App\Platform\Classes\Users\UserStatus;
    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

    class UpdateUserRoleRequest extends FormRequest {
        /**
         * Only Admins and Super Admins may perform this request.
         */
        public function authorize(): bool
        {
            return $this->user() && in_array($this->user()->role, ['Admin', 'Super Admin'], true);
        }

        /**
         * Only feed these two keys into the validator.
         */
        public function validationData(): array
        {
            return $this->only(['role', 'status']);
        }

        public function rules(): array
        {
            return [
                'role'   => ['required', Rule::in(Roles::values())],
                'status' => [
                    'required',
                    Rule::in([
                                 UserStatus::Inactive->value,
                                 UserStatus::Active->value,
                                 UserStatus::Suspended->value,
                             ]),
                ],
            ];
        }


        /**
         * Custom error messages for validation.
         */
        public function messages(): array
        {
            return [
                'role.required'   => 'Please select a role for the user.',
                'role.in'         => 'The selected role is invalid.',
                'status.required' => 'Please select a status for the user.',
                'status.in'       => 'The selected status is invalid.',
            ];
        }

        /**
         * Guarantee only role and status are ever returned.
         * @param null $key
         * @param null $default
         */
        public function validated($key = null, $default = null): array
        {
            $data = parent::validated();

            return [
                'role'   => $data['role'],
                'is_active' => UserStatus::from($data['status'])->label(),
            ];
        }

        public function prepareForValidation(): void
        {
            $this->merge([
                             'status' => UserStatus::tryFromName($this->status)?->value ?? 0,
                         ]);
        }
    }
