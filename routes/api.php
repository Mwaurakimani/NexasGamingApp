<?php

    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
    use function Illuminate\Log\log;

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::middleware('auth:sanctum')->get('/users', function () {
        return User::all();
    });

    Route::post('/mobile/login', function (Request $request) {
        $credentials = $request->validate([
                                              'email'    => ['required', 'email'],
                                              'password' => ['required'],
                                          ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();

        $user->tokens()->delete();

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
                                    'token' => $token,
                                    'user'  => $user,
                                ]);
    });

    Route::middleware('auth:sanctum')->get('/mobile/dashboard', function () {
        $transactions = $transactions = [
            [
                'id'        => 1,
                'username'  => 'JOEL MWANGI',
                'email'     => fake()->email(),
                'phone'     => '0792820310',
                'amount'    => 200,
                'status'    => 'confirmed',
                'reference' => 'TDH47CSLUG',
                'date'      => '2025-04-17',
                'time'      => '10:30 PM',
            ],
            [
                'id'        => 2,
                'username'  => 'GLADYS KAMAU',
                'email'     => fake()->email(),
                'phone'     => '0717607177',
                'amount'    => 250,
                'status'    => 'confirmed',
                'reference' => 'TDH26ZL9CY',
                'date'      => '2025-04-17',
                'time'      => '09:00 PM',
            ],
            [
                'id'        => 3,
                'username'  => 'EDINAH MARANGA',
                'email'     => fake()->email(),
                'phone'     => '0757541696',
                'amount'    => 100,
                'status'    => 'confirmed',
                'reference' => 'TDH347VHYZ',
                'date'      => '2025-04-17',
                'time'      => '12:35 PM',
            ],
            [
                'id'        => 4,
                'username'  => 'MARYANN MWAURA',
                'email'     => fake()->email(),
                'phone'     => '0700612093',
                'amount'    => 500,
                'status'    => 'confirmed',
                'reference' => 'TDH53YMFVP',
                'date'      => '2025-04-17',
                'time'      => '11:34 AM',
            ],
            [
                'id'        => 5,
                'username'  => 'NORAH MACHATHA',
                'email'     => fake()->email(),
                'phone'     => '0769784347',
                'amount'    => 200,
                'status'    => 'confirmed',
                'reference' => 'TDH63Y84NO',
                'date'      => '2025-04-17',
                'time'      => '11:32 AM',
            ],
            [
                'id'        => 6,
                'username'  => 'LORINE MASOSO',
                'email'     => fake()->email(),
                'phone'     => '0700000006',
                'amount'    => 80,
                'status'    => 'confirmed',
                'reference' => 'TDG923VQ5H',
                'date'      => '2025-04-16',
                'time'      => '08:57 PM',
            ],
            [
                'id'        => 7,
                'username'  => 'LUCY MAINA',
                'email'     => fake()->email(),
                'phone'     => '0700000007',
                'amount'    => 20,
                'status'    => 'confirmed',
                'reference' => 'TDG6237OO6',
                'date'      => '2025-04-16',
                'time'      => '08:53 PM',
            ],
            [
                'id'        => 8,
                'username'  => 'GLADYS KAMAU',
                'email'     => fake()->email(),
                'phone'     => '0717607177',
                'amount'    => 250,
                'status'    => 'confirmed',
                'reference' => 'TDG0226ULE',
                'date'      => '2025-04-16',
                'time'      => '08:48 PM',
            ],
            [
                'id'        => 9,
                'username'  => 'EDINAH MARANGA',
                'email'     => fake()->email(),
                'phone'     => '0757541696',
                'amount'    => 80,
                'status'    => 'confirmed',
                'reference' => 'TDG2ZH4F38',
                'date'      => '2025-04-16',
                'time'      => '04:31 PM',
            ],
            [
                'id'        => 10,
                'username'  => 'LUCY MAINA',
                'email'     => fake()->email(),
                'phone'     => '0700000010',
                'amount'    => 70,
                'status'    => 'confirmed',
                'reference' => 'TDG4ZFH6OM',
                'date'      => '2025-04-16',
                'time'      => '04:21 PM',
            ],
            [
                'id'        => 11,
                'username'  => 'NORAH MACHATHA',
                'email'     => fake()->email(),
                'phone'     => '0769784347',
                'amount'    => 50,
                'status'    => 'confirmed',
                'reference' => 'TDG0ZAMPTE',
                'date'      => '2025-04-16',
                'time'      => '03:50 PM',
            ],
        ];

        return response()->json([
                                    'token_balance'   => 30000,
                                    'inbound_amount'  => 2000,
                                    'outbound_amount' => 1000,
                                    'transactions'    => [
                                        'data'         => $transactions,
                                        'current_page' => 1,
                                        'last_page'    => 1,
                                    ]
                                ]);
    });

    Route::middleware('auth:sanctum')->post('/mpesa/proofs', function (Request $request) {
        log()->info($request);
        return ['success'];
    });
