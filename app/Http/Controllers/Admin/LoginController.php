<?php
    namespace App\Http\Controllers\Admin;

    use App\Service\Admin\AdminService;
    use Gregwar\Captcha\CaptchaBuilder;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cookie;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Input;

    class LoginController {
        protected $adminService;

        public function __construct()
        {
            $this->adminService = app(AdminService::class);
        }

        public function login(Request $request)
        {
//            处理的登录请求
            if($input = Input::all()){
                $return = $this->adminService->checkLogin($input);
                if(!array_key_exists('failReason', $return)) {
                    // 判断是否记住密码
                    if(isset($input['remember']) && $input['remember'] == 1) {
//                        登录界面
                        $cookieSaveTime = config('admin.app.cookieSaveTime');
                        Cookie::queue('username', $input['username'], $cookieSaveTime);
                        Cookie::queue('password', $input['password'], $cookieSaveTime);
                    } else {
                        if($request->url() === url('admin/login')) {
                            Cookie::queue('username', null, -1);
                            Cookie::queue('password', null, -1);
                        }
                    }
                    session(['user' => $return]);
//                    如果是锁屏界面，跳转到之前的页面
                    if($request->url() === url('admin/lockscreen')) {
                        return redirect(Cookie::get('old_url'));
                    }
                    return redirect('admin/index');
                } else {
                    return back()->with('msg', $return['failReason']);
                }
            }else {
                return view('admin.auth.login');
            }
        }

        public function logOut()
        {
            session(['user' => null]);
            return redirect('admin/login');
        }

        public function lockScreen(Request $request)
        {
            $username = null;
            $email = null;
            // 保存退出登录前的url
            if(null !== Cookie::get('old_url') && url('admin/lockscreen') == $request->server('HTTP_REFERER')) {
//                如果是刷新操作，什么都不做
            } else {
                Cookie::queue('old_url', $request->server('HTTP_REFERER'), config('admin.app.cookieSaveTime'));
            }
            if($user = session('user')) {
                $username = session('user')->admin_username;
                $email = session('user')->admin_email;
                Cookie::queue('username', $username, 20);
                Cookie::queue('email', $email, 20);
            } else {
                if(null !== Cookie::get('username')) {
                    $username = Cookie::get('username');
                    $email = Cookie::get('email');
                } else {
                    return redirect('admin/login');
                }
            }

//            销毁session
            session(['user' => null]);
            return view('admin.auth.lock', ['username' => $username, 'email' => $email]);
        }

        function getCode() {
            $builder = new CaptchaBuilder();
            //设置图片宽高和字体
            $builder->build(100, 40, $font = null);
            // 获取验证码的内容
            $phrase = $builder->getPhrase();

            session("milkcaptcha", $phrase);

//            生成图片
            header("Cache-Control: no-cache, must-revalidate");
            header('Content-type: image/jpeg');
            $builder->output();
            return view('welcome');
        }

        function testMutilLang() {
            echo trans('validation.accepted');
        }

        function test() {
            echo Hash::make("root");
            echo "<br/>";
            echo strlen(Hash::make("root"));
            echo "<br/>";
            echo date("Y-m-d h:i:s", time());
        }
    }