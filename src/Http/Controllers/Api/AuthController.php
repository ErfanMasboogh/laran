<?php

namespace ErfanMasboogh\Laran\Http\Controllers\Api;

use ErfanMasboogh\Laran\Http\Requests\Api\Auth\RegisterRequest;
use ErfanMasboogh\Laran\Http\Requests\Api\Auth\VerifyRequest;
use ErfanMasboogh\Laran\Http\Requests\Web\Auth\LoginRequest;
use ErfanMasboogh\Laran\Repositories\User\UserRepository;
use ErfanMasboogh\Laran\Services\Auth\AuthService;
use ErfanMasboogh\Laran\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Random\RandomException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    protected $authService;
    protected $userService;
    protected $userRepo;

    public function __construct(AuthService $authService, UserService $userService, UserRepository $userRepo)
    {
        $this->authService = $authService;
        $this->userService = $userService;
        $this->userRepo = $userRepo;
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws RandomException
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $result = $this->authService->register($data);

        if ($result === true) {
            return $this->success([
                'mobile' => $data['mobile']
            ]);
        }

        return $this->error(lt('Send otp failed'), ResponseAlias::HTTP_BAD_GATEWAY);
    }

    /**
     * @param VerifyRequest $request
     * @return JsonResponse
     */
    public function verify(VerifyRequest $request)
    {
        $data = $request->validated();

        $data = $this->authService->verify($data);
        $user = $this->userService->createUser($data, true);
        $token = $this->authService->createAuthToken($user);

        return $this->success([
            'token' => $token,
            'tokenType' => 'Bearer',
        ]);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $data['ip'] = $request->ip();

        $user = $this->userRepo->findByMobile($data['mobile']);
        $token = $this->authService->login($user, $data);

        return $this->success([
            'token' => $token,
            'tokenType' => 'Bearer',
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function logout()
    {
        $user = auth()->user();

        $this->authService->logout($user);

        return $this->success();
    }
}
