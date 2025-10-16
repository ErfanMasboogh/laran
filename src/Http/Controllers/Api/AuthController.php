<?php

namespace ErfanMasboogh\Laran\Http\Controllers\Api;

use ErfanMasboogh\Laran\Http\Requests\Api\Auth\RegisterRequest;
use ErfanMasboogh\Laran\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
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
}
