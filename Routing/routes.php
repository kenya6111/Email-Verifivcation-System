<?php

require_once "vendor/autoload.php";
use Helpers\DatabaseHelper;
use Helpers\Mail;
use Helpers\ValidationHelper;
use Helpers\Authenticate;
use Response\HTTPRenderer;
use Response\FlashData;
use Response\Render\HTMLRenderer;
use Response\Render\JSONRenderer;
use Response\Render\RedirectRenderer;
use Response\Render\MediaRenderer;
use Database\DataAccess\Implementations\ComputerPartDAOImpl;
use Models\ComputerPart;
use Models\User;
use Models\Post;
use Types\ValueType;
use Database\DataAccess\DAOFactory;
use Exceptions\AuthenticationFailureException;
use Routing\Route;
return [
    'login' => Route::create('login', function (): HTTPRenderer {
        return new HTMLRenderer('page/login');
    })->setMiddleware(['guest']),
    'form/login' => Route::create('form/login', function (): HTTPRenderer {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new Exception('Invalid request method!');

            $required_fields = [
                'email' => ValueType::EMAIL,
                'password' => ValueType::STRING,
            ];

            $validatedData = ValidationHelper::validateFields($required_fields, $_POST);

            Authenticate::authenticate($validatedData['email'], $validatedData['password']);

            FlashData::setFlashData('success', 'Logged in successfully.');
            return new RedirectRenderer('update/part');
        } catch (AuthenticationFailureException $e) {
            error_log($e->getMessage());

            FlashData::setFlashData('error', 'Failed to login, wrong email and/or password.');
            return new RedirectRenderer('login');
        } catch (\InvalidArgumentException $e) {
            error_log($e->getMessage());

            FlashData::setFlashData('error', 'Invalid Data.');
            return new RedirectRenderer('login');
        } catch (Exception $e) {
            error_log($e->getMessage());

            FlashData::setFlashData('error', 'An error occurred.');
            return new RedirectRenderer('login');
        }
    })->setMiddleware(['guest']),
    'register' => Route::create('register', function (): HTTPRenderer {
        return new HTMLRenderer('page/register');
    })->setMiddleware(['guest']),
    'form/register' => Route::create('form/register', function (): HTTPRenderer {
        try {
            // リクエストメソッドがPOSTかどうかをチェックします
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new Exception('Invalid request method!');

            $required_fields = [
                'username' => ValueType::STRING,
                'email' => ValueType::EMAIL,
                'password' => ValueType::PASSWORD,
                'confirm_password' => ValueType::PASSWORD,
                'company' => ValueType::STRING,
            ];

            $userDao = DAOFactory::getUserDAO();

            // シンプルな検証
            $validatedData = ValidationHelper::validateFields($required_fields, $_POST);

            if($validatedData['confirm_password'] !== $validatedData['password']){
                FlashData::setFlashData('error', 'Invalid Password!');
                return new RedirectRenderer('register');
            }

            // Eメールは一意でなければならないので、Eメールがすでに使用されていないか確認します
            if($userDao->getByEmail($validatedData['email'])){
                FlashData::setFlashData('error', 'Email is already in use!');
                return new RedirectRenderer('register');
            }

            // 新しいUserオブジェクトを作成します
            $user = new User(
                username: $validatedData['username'],
                email: $validatedData['email'],
                company: $validatedData['company']
            );

            // データベースにユーザーを作成しようとします
            $success = $userDao->create($user, $validatedData['password']);

            if (!$success) throw new Exception('Failed to create new user!');

            // ユーザーログイン
            Authenticate::loginAsUser($user);

            FlashData::setFlashData('success', 'Account successfully created.');

            $expiration = time()+1800;//現在の時間+30分
            $queryParameters = [
                "id" => $user->getId(),
                "user" => password_hash($user->getEmail(), PASSWORD_DEFAULT),
                "expiration" => $expiration
            ];

            $url = Route::create("verify/email", function(){})->getSignedURL($queryParameters);

            // 署名付き検証 URL を生成し、ユーザーのメールアドレスに送信します。
            Mail::sendVerificationEmail($url, $user->getEmail());
            FlashData::setFlashData('success', 'We have sent a verification email to your email address!');

            return new RedirectRenderer('random/part');// ここの遷移先を「メール送信しました」的な画面にしようか。
        } catch (\InvalidArgumentException $e) {
            error_log($e->getMessage());

            FlashData::setFlashData('error', 'Invalid Data.');
            return new RedirectRenderer('register');
        } catch (Exception $e) {
            error_log($e->getMessage());

            FlashData::setFlashData('error', 'An error occurred.');
            return new RedirectRenderer('register');
        }
    })->setMiddleware(['guest']),
    'logout' => Route::create('logout', function (): HTTPRenderer {
        Authenticate::logoutUser();
        FlashData::setFlashData('success', 'Logged out.');
        return new RedirectRenderer('random/part');
    })->setMiddleware(['auth']),
    'random/part' => Route::create('random/part', function (): HTTPRenderer {
        $partDao = DAOFactory::getComputerPartDAO();
        $part = $partDao->getRandom();

        if($part === null) throw new Exception('No parts are available!');

        return new HTMLRenderer('component/computer-part-card', ['part'=>$part]);
    }),
    'parts' => Route::create('parts', function (): HTTPRenderer {
        // IDの検証
        $id = ValidationHelper::integer($_GET['id']??null);

        $partDao = DAOFactory::getComputerPartDAO();
        $part = $partDao->getById($id);

        if($part === null) throw new Exception('Specified part was not found!');

        return new HTMLRenderer('component/computer-part-card', ['part'=>$part]);
    }),
    'update/part' => Route::create('update/part', function (): HTTPRenderer {
        $user = Authenticate::getAuthenticatedUser();
        $part = null;
        $partDao = DAOFactory::getComputerPartDAO();
        if(isset($_GET['id'])){
            $id = ValidationHelper::integer($_GET['id']);
            $part = $partDao->getById($id);
            if($user->getId() !== $part->getSubmittedById()){
                FlashData::setFlashData('error', 'Only the author can edit this computer part.');
                return new RedirectRenderer('register');
            }
        }
        return new HTMLRenderer('component/update-computer-part',['part'=>$part]);
    })->setMiddleware(['auth']),
    'form/update/part' => Route::create('form/update/part', function (): HTTPRenderer {
        try {
            // クエストメソッドがPOSTかどうかをチェックします
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Invalid request method!');
            }

            $required_fields = [
                'name' => ValueType::STRING,
                'type' => ValueType::STRING,
                'brand' => ValueType::STRING,
                'modelNumber' => ValueType::STRING,
                'releaseDate' => ValueType::DATE,
                'description' => ValueType::STRING,
                'performanceScore' => ValueType::INT,
                'marketPrice' => ValueType::FLOAT,
                'rsm' => ValueType::FLOAT,
                'powerConsumptionW' => ValueType::FLOAT,
                'lengthM' => ValueType::FLOAT,
                'widthM' => ValueType::FLOAT,
                'heightM' => ValueType::FLOAT,
                'lifespan' => ValueType::INT,
            ];

            $partDao = DAOFactory::getComputerPartDAO();

            // 入力に対する単純な認証。実際のシナリオでは、要件を満たす完全な認証が必要になることがあります
            $validatedData = ValidationHelper::validateFields($required_fields, $_POST);

            $user = Authenticate::getAuthenticatedUser();

            // idが設定されている場合は、認証を行います
            if(isset($_POST['id'])){
                $validatedData['id'] = ValidationHelper::integer($_POST['id']);
                $currentPart = $partDao->getById($_POST['id']);
                if($currentPart === null || $user->getId() !== $currentPart->getSubmittedById()){
                    return new JSONRenderer(['status' => 'error', 'message' => 'Invalid Data Permissions!']);
                }
            }

            $validatedData['submitted_by_id'] = $user->getId();

            $part = new ComputerPart(...$validatedData);

            error_log(json_encode($part->toArray(), JSON_PRETTY_PRINT));

            // 新しい部品情報でデータベースの更新を試みます。
            // 別の方法として、createOrUpdateを実行することもできます。
            if(isset($validatedData['id'])) $success = $partDao->update($part);
            else $success = $partDao->create($part);

            if (!$success) {
                throw new Exception('Database update failed!');
            }

            return new JSONRenderer(['status' => 'success', 'message' => 'Part updated successfully', 'id'=>$part->getId()]);
        } catch (\InvalidArgumentException $e) {
            error_log($e->getMessage());
            return new JSONRenderer(['status' => 'error', 'message' => 'Invalid data.']);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return new JSONRenderer(['status' => 'error', 'message' => 'An error occurred.']);
        }
    })->setMiddleware(['auth']),
    'test/share/files/jpg'=> Route::create('test/share/files/jpg', function(): HTTPRenderer{
        // このURLは署名を必要とするため、URLが正しい署名を持つ場合にのみ、この最終ルートコードに到達します。
        $required_fields = [
            'user' => ValueType::STRING,
            'filename' => ValueType::STRING, // 本番環境では、有効なファイルパスに対してバリデーションを行いますが、ファイルパスの単純な文字列チェックを行います。
        ];

        $validatedData = ValidationHelper::validateFields($required_fields, $_GET);

        return new MediaRenderer(sprintf("private/shared/%s/%s", $validatedData['user'],$validatedData['filename']), 'jpg');
    })->setMiddleware(['signature']),
    'test/share/files/jpg/generate-url'=> Route::create('test/share/files/jpg/generate-url', function(): HTTPRenderer{
        $required_fields = [
            'user' => ValueType::STRING,
            'filename' => ValueType::STRING,
        ];

        $validatedData = ValidationHelper::validateFields($required_fields, $_GET);

        if(isset($_GET['lasts'])){
            $validatedData['expiration'] = time() + ValidationHelper::integer($_GET['lasts']);
        }

        return new JSONRenderer(['url'=>Route::create('test/share/files/jpg', function(){})->getSignedURL($validatedData)]);
    }),
    'verify/email'=> Route::create('verify/email', function(): HTTPRenderer{
        try {
            $id = Authenticate::getAuthenticatedUser()->getId();
            $email = Authenticate::getAuthenticatedUser()->getEmail();
            $idCheck = !isset($_GET['id']) || $id !== (int)$_GET['id'];
            $userCheck = !isset($_GET['user']) || !password_verify($email, $_GET['user']);

            // ユーザーの詳細がURLパラメータと一致していることを確認します。
            if($idCheck || $userCheck){
                FlashData::setFlashData('error', "The URL is invalid.");
                return new RedirectRenderer('random/part');
            }

            $required_fields = [
                'id' => ValueType::INT,
                'user' => ValueType::STRING,
            ];

            $validatedData = ValidationHelper::validateFields($required_fields, $_GET);

            $userDao = DAOFactory::getUserDAO();
            $user = $userDao->getById($id);

            // データベースの email_verified 列を更新します。
            $success = $userDao->update($user, $userDao->getHashedPasswordById($id), date("Y-m-d H:i:s"));

            if (!$success) throw new Exception('Failed to update!');

            FlashData::setFlashData('success', 'Your registration has been completed!');

            // return new RedirectRenderer('update/part');
            return new RedirectRenderer('homepage');
        } catch (\InvalidArgumentException $e) {
            error_log($e->getMessage());

            FlashData::setFlashData('error', 'Invalid Data.');
            return new RedirectRenderer('verify/resend');

        } catch (Exception $e) {
            error_log($e->getMessage());

            FlashData::setFlashData('error', 'An error occurred.');
            return new RedirectRenderer('verify/resend');
        }
    }),
    'verify/resend'=> Route::create('verify/resend', function(): HTTPRenderer{
        return new HTMLRenderer('page/send-verification-email');
    }),
    'form/verify/resend' => Route::create('form/verify/resend', function (): HTTPRenderer {
        try {
            // リクエストメソッドがPOSTかどうかをチェックします
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new Exception('Invalid request method!');

            $isNewEmail = false;

            $required_fields = [
                'email' => ValueType::EMAIL,
                'password' => ValueType::PASSWORD,
            ];

            // new_emailに入力があれば、値を検証する
            if(isset($_POST["new_email"]) && $_POST["new_email"] !== ""){
                $required_fields["new_email"] = ValueType::EMAIL;
                $isNewEmail = true;
            }

            // シンプルな検証
            $validatedData = ValidationHelper::validateFields($required_fields, $_POST);

            $userDao = DAOFactory::getUserDAO();
            $user = $userDao->getByEmail($validatedData['email']);


            // 入力されたEメールが存在しない場合は、無効なE-メールと判断します
            if($user === null){
                FlashData::setFlashData('error', 'Email is not registered!');
                return new RedirectRenderer('register');
            }

            // 入力されたパスワードが登録時のパスワードと一致しない場合は、無効なパスワードと判断します
            if(!password_verify($validatedData["password"], $userDao->getHashedPasswordById($user->getId()))){
                FlashData::setFlashData('error', 'Invalid Password! Password : '.$validatedData["password"]);
                return new RedirectRenderer('register');
            }

            // 新しいEメールが入力されていれば、データベースのメールアドレスを変更します。
            if($isNewEmail){
                $user->setEmail($validatedData["new_email"]);

                $success = $userDao->update($user, password_hash($validatedData['password'], PASSWORD_DEFAULT), null);
    
                if (!$success) throw new Exception('Failed to update!');
            }

            // urlに必要な情報を定義する
            $expiration = time() + 1800; // 現在時刻の時間 + 30分

            $queryParameters = [
                "id" => $user->getId(),
                "user" => $user->getUsername(),
                "expiration" => $expiration
            ];
            
            $url = Route::create("verify/email", function(){})->getSignedURL($queryParameters);

            // 署名付き検証 URL を生成し、ユーザーのメールアドレスに送信します。
            Mail::sendVerificationEmail($url, $user->getEmail());

            FlashData::setFlashData('success', 'We have sent a verification email to your email address!');

            return new RedirectRenderer('random/part');
        } catch (\InvalidArgumentException $e) {
            error_log($e->getMessage());

            FlashData::setFlashData('error', 'Invalid Data.');
            return new RedirectRenderer('verify/resend');

        } catch (Exception $e) {
            error_log($e->getMessage());

            FlashData::setFlashData('error', 'An error occurred.');
            return new RedirectRenderer('verify/resend');
        }
    }),

    'homepage' => Route::create('homepage', function (): HTTPRenderer {
        $postDao = DAOFactory::getPostDAO();
        $posts = $postDao->getPostsOrderedByLikesDesc();
        return new HTMLRenderer('page/home',['posts'=>$posts,'loginUserId' => $_SESSION['user_id']]);
    })->setMiddleware(['auth']),
    'form/post' => Route::create('form/post', function (): HTTPRenderer {
        try {
            // リクエストメソッドがPOSTかどうかをチェックします
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new Exception('Invalid request method!');

            $required_fields = [
                'text' => ValueType::STRING,
            ];
            // 入力に対する単純な認証。実際のシナリオでは、要件を満たす完全な認証が必要になることがあります
            $validatedData = ValidationHelper::validateFields($required_fields, $_POST);


            $postDao = DAOFactory::getPostDAO();

            // シンプルな検証
            //$validatedData = ValidationHelper::validateFields($required_fields, $_POST);
            $tmpPath = $_FILES['file-upload']['tmp_name'];
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($tmpPath);
            $byteSize = filesize($tmpPath);

            $ipAddress = $_SERVER['REMOTE_ADDR'];
             /* 拡張子情報の取得・セット */
             $imginfo = getimagesize($_FILES['file-upload']['tmp_name']);
            if($imginfo['mime'] == 'image/jpeg'){ $extension = ".jpg"; }
            if($imginfo['mime'] == 'image/png'){ $extension = ".png"; }
            if($imginfo['mime'] == 'image/gif'){ $extension = ".gif"; }

            $extension = explode('/', $mime)[1];

            $filename = hash('sha256', uniqid(mt_rand(), true)) . '.' . $extension;
            $uploadDir =   './uploads/'; 
            $subdirectory = substr($filename, 0, 2);
            $imagePath = $uploadDir .  $subdirectory. '/' . $filename;
            // アップロード先のディレクトリがない場合は作成
            if(!is_dir(dirname($imagePath))){
                mkdir(dirname($imagePath),0777,true);
                chmod(dirname($imagePath), 0775);
            }
            // $imagesDir =   './images/';
            // $svgfilename = 'checkmark.svg';
            // chmod(dirname($imagesDir.$svgfilename), 0775);

            // アップロードにした場合は失敗のメッセージを送る
            if(move_uploaded_file($tmpPath, $imagePath)){
                chmod($imagePath, 0664);
            }else{
                return new JSONRenderer(['success' => false, 'message' => 'アップロードに失敗しました。']);
            }

            $hash_for_shared_url = hash('sha256', uniqid(mt_rand(), true));
            // $hash_for_delete_url = hash('sha256', uniqid(mt_rand(), true));
            $shared_url = '/' . $extension . '/' . $hash_for_shared_url;
            // $delete_url = '/' .  'delete' . '/' . $hash_for_delete_url;
            $imagePathFromUploadDir = $subdirectory . '/'.$filename;

            $message = $validatedData['text'];
            
            $result = $postDao->create($message,$imagePathFromUploadDir,$_FILES['file-upload']['name'],$_FILES['file-upload']['type'],$_FILES['file-upload']['size'],$shared_url);

            $posts = $postDao->getPostsOrderedByLikesDesc();
            

            // return new HTMLRenderer('page/home',['posts'=>$posts]);
            return new RedirectRenderer('homepage');
            
        } catch (\InvalidArgumentException $e) {
            error_log($e->getMessage());

            FlashData::setFlashData('error', 'Invalid Data.');
            return new RedirectRenderer('register');
        } catch (Exception $e) {
            error_log($e->getMessage());

            FlashData::setFlashData('error', 'An error occurred.');
            return new RedirectRenderer('register');
        }
    })->setMiddleware(['auth']),
    'profile' => Route::create('profile', function (): HTTPRenderer {
        $userDao = DAOFactory::getUserDAO();
        $postDao = DAOFactory::getPostDAO();
        $user=null;
        $posts=null;
        if(isset($_GET['user_id'])){
            $id = ValidationHelper::integer($_GET['user_id']);
            $user = $userDao->getById($id);
            $posts = $postDao->getById($id);
            $followNum = $userDao->getFollowNumById($id);
            $followerNum = $userDao->getFollowerNumById($id);
        }

        return new HTMLRenderer('component/profile',['user' => $user, 'posts' => $posts,'loginUserId' => $_SESSION['user_id'], 'followNum' => $followNum, 'followerNum' => $followerNum]);
    })->setMiddleware(['auth']),
    'follow' => Route::create('follow', function (): HTTPRenderer {
        $userDao = DAOFactory::getUserDAO();
        $user = null;
        if(isset($_POST['user_id'])){
            $id = ValidationHelper::integer($_POST['user_id']);
            $result = $userDao->insertFollowRecord($id,$_SESSION['user_id']);
        }

        // return new HTMLRenderer('component/profile',['status' => $result]);
        // return new RedirectRenderer('profile');  
        return new JSONRenderer(['status' => $result]);
    })->setMiddleware(['auth']),
    'unfollow' => Route::create('follow', function (): HTTPRenderer {
        $userDao = DAOFactory::getUserDAO();
        $user = null;
        if(isset($_POST['user_id'])){
            $id = ValidationHelper::integer($_POST['user_id']);
            $result = $userDao->deleteFollowRecord($id,$_SESSION['user_id']);
        }

        // return new HTMLRenderer('component/profile',['status' => $result]);
        // return new RedirectRenderer('profile');  
        return new JSONRenderer(['status' => $result]);
    })->setMiddleware(['auth']),
    'notice' => Route::create('notice', function (): HTTPRenderer {
        // $user = Authenticate::getAuthenticatedUser();
        // $part = null;
        // $partDao = DAOFactory::getComputerPartDAO();
        // if(isset($_GET['id'])){
        //     $id = ValidationHelper::integer($_GET['id']);
        //     $part = $partDao->getById($id);
        //     if($user->getId() !== $part->getSubmittedById()){
        //         FlashData::setFlashData('error', 'Only the author can edit this computer part.');
        //         return new RedirectRenderer('register');
        //     }
        // }
        return new HTMLRenderer('component/notifications');
    })->setMiddleware(['auth']),
    'message' => Route::create('message', function (): HTTPRenderer {
        // $user = Authenticate::getAuthenticatedUser();
        // $part = null;
        // $partDao = DAOFactory::getComputerPartDAO();
        // if(isset($_GET['id'])){
        //     $id = ValidationHelper::integer($_GET['id']);
        //     $part = $partDao->getById($id);
        //     if($user->getId() !== $part->getSubmittedById()){
        //         FlashData::setFlashData('error', 'Only the author can edit this computer part.');
        //         return new RedirectRenderer('register');
        //     }
        // }
        return new HTMLRenderer('component/message');
    })->setMiddleware(['auth']),
    'followList' => Route::create('followList', function (): HTTPRenderer {
        //  $user = Authenticate::getAuthenticatedUser();
         $userDao = DAOFactory::getUserDAO();
        if(isset($_GET['user_id'])){
            $id = ValidationHelper::integer($_GET['user_id']);
            $followUsers = $userDao->getFollowListById($id);
            $followerUsers = $userDao->getFollowerListById($id);
        }
        return new HTMLRenderer('component/follow',['followUsers' => $followUsers,'followerUsers' => $followerUsers]);
    })->setMiddleware(['auth']),
    'post' => Route::create('post', function (): HTTPRenderer {
        $userDao = DAOFactory::getUserDAO();
        $postDao = DAOFactory::getPostDAO();
        $user=null;
        $posts=null;
        if(isset($_GET['user_id'])){
            $id = ValidationHelper::integer($_GET['user_id']);
            $user = $userDao->getById($id);
            $posts = $postDao->getById($id);
        }



        return new HTMLRenderer('component/post',['user' => $user, 'posts' => $posts,'loginUserId' => $_SESSION['user_id']]);
    })->setMiddleware(['auth']),
];