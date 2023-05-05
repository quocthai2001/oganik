<!DOCTYPE HTML>
<html>

<head>
    <title>Register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;700&display=swap" rel="stylesheet" />

    <link href="../assets/css/register.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" type="image/png" href="../assets/images/loader.png" />

</head>

<body>
    <!-- CODE XỬ LÝ PHP -->
    <?php
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=oganik", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Lỗi kết nối đến CSDL: " . $e->getMessage();
        die();
    }
    require_once('../class/customer.php');


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $fullname = $_POST['fullname'];
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $role = 1;
            // $from_email = $email;
            require('../phpmailer/src/PHPMailer.php');
            require('../phpmailer/src/Exception.php');
            require('../phpmailer/src/SMTP.php');
            // send mail
            // $config = array();
            $protocol = 'smtp';
            $host = 'ssl://smtp.gmail.com';
            $smtp_username = 'shopoganik2023@gmail.com';
            $smtp_password = 'Shopoganik@2023';
            $charset = 'utf-8';
            $encryption = 'tls';
            $to_email = $_POST['email'];
            $port = 587;
            $subject = 'OGANIK';
            $message = 'Chúc mừng bạn đã đăng ký tài khoản thành công !';
            $mail = new PHPMailer\PHPMailer\PHPMailer();

            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = $host;
            $mail->Port = $port;
            $mail->SMTPSecure = $encryption;;
            $mail->Username = $smtp_username;
            $mail->Password = $smtp_password;
            // Thiết lập địa chỉ người gửi, người nhận và tiêu đề email
            $mail->setFrom($smtp_username);
            $mail->addAddress($to_email);
            $mail->Subject = $subject;
            // Thiết lập nội dung email
            $mail->Body = $message;
            // Gửi email và kiểm tra kết quả
            // ---------------------------
            $stmt = $pdo->prepare("SELECT * FROM customers WHERE username=:username");
            $stmt->execute(array(':username' => $username));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $message = "Tài khoản đã tồn tại !";
                echo "<script type='text/javascript'>alert('$message');
                window.location.replace('register.php');
                </script>";
                die();
            }
            $stmt = $pdo->prepare("SELECT * FROM customers WHERE email=:email");
            $stmt->execute(array(':email' => $email));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $message = "Email đã tồn tại !";
                echo "<script type='text/javascript'>alert('$message');
                window.location.replace('register.php');
                </script>";
                die();
            }

            if ($username != '' && $fullname != '' && $password != '' && $address != '') {
                if ($password == $repassword) {
                    $register = customer_insert($username, $fullname, $password, $email, $phone, $address, $role);
                    $mail->send($to_email, $subject, $message);
                    $message = "Mời bạn đăng nhập để mua hàng !";
                    echo "<script type='text/javascript'>alert('$message');
                    window.location.replace('login.php');
                    </script>";
                } elseif ($password != $repassword) {
                    echo '<script language="javascript">';
                    echo 'alert("Xác nhận mật khẩu không chính xác !")';
                    echo '</script>';
                }
            } else {
                echo '<script language="javascript">';
                echo 'alert("Vui lòng điền đầy đủ thông tin !")';
                echo '</script>';
            }
        }
        unset($username, $fullname, $password, $email1, $phone, $address);
    }
    ?>

    <!-- -->
    <div class="limiter" style="width:450px;height:750px">
        <div class="logo"></div>
        <br>
        <form method="post">
            <div class="title" style="margin-top: -100px">Register</div>
            <div class="wrap-login100" style="">
                <div class="wrap-input100 validate-input">
                    <svg class="svg-icon" viewBox="0 0 20 20">
                        <path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,
            5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,
            0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,
            1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,
            0,6.486,2.787,6.705,6.297H3.415z"></path>
                    </svg>
                    <input type="text" class="input100" name="username" placeholder="Username">
                    <span class="focus-input100" data-placeholder="&#xf18e;"></span>
                </div>
                <div class="wrap-input100 validate-input">
                    <svg class="svg-icon" viewBox="0 0 20 20">
                        <path d="M8.749,9.934c0,0.247-0.202,0.449-0.449,0.449H4.257c-0.247,0-0.449-0.202-0.449-0.449S4.01,9.484,4.257,
                9.484H8.3C8.547,9.484,8.749,9.687,8.749,9.934 M7.402,12.627H4.257c-0.247,0-0.449,0.202-0.449,0.449s0.202,0.449,
                0.449,0.449h3.145c0.247,0,0.449-0.202,0.449-0.449S7.648,12.627,7.402,12.627 M8.3,6.339H4.257c-0.247,0-0.449,0.202-0.449,
                0.449c0,0.247,0.202,0.449,0.449,0.449H8.3c0.247,0,0.449-0.202,0.449-0.449C8.749,6.541,8.547,6.339,8.3,6.339 M18.631,
                4.543v10.78c0,0.248-0.202,0.45-0.449,0.45H2.011c-0.247,0-0.449-0.202-0.449-0.45V4.543c0-0.247,0.202-0.449,
                0.449-0.449h16.17C18.429,4.094,18.631,4.296,18.631,4.543 M17.732,4.993H2.46v9.882h15.272V4.993z M16.371,13.078c0,
                0.247-0.202,0.449-0.449,0.449H9.646c-0.247,0-0.449-0.202-0.449-0.449c0-1.479,0.883-2.747,
                2.162-3.299c-0.434-0.418-0.714-1.008-0.714-1.642c0-1.197,0.997-2.246,2.133-2.246s2.134,1.049,2.134,2.246c0,0.634-0.28,
                1.224-0.714,1.642C15.475,10.331,16.371,11.6,16.371,13.078M11.542,8.137c0,0.622,0.539,1.348,1.235,1.348s1.235-0.726,
                1.235-1.348c0-0.622-0.539-1.348-1.235-1.348S11.542,7.515,11.542,8.137 M15.435,12.629c-0.214-1.273-1.323-2.246-2.657-2.246s-2.431,0.973-2.644,2.246H15.435z"></path>
                    </svg>
                    <input type="text" class="input100" name="fullname" placeholder="Fullname">
                    <span class="focus-input100" data-placeholder="&#xf18e;"></span>
                </div>
                <div class="passwwrap-input100 validate-input">
                    <svg class="svg-icon" viewBox="0 0 20 20">
                        <path d="M17.308,7.564h-1.993c0-2.929-2.385-5.314-5.314-5.314S4.686,4.635,4.686,7.564H2.693c-0.244,0-0.443,0.2-0.443,
            0.443v9.3c0,0.243,0.199,0.442,0.443,0.442h14.615c0.243,0,0.442-0.199,0.442-0.442v-9.3C17.75,7.764,17.551,7.564,17.308,
            7.564 M10,3.136c2.442,0,4.43,1.986,4.43,4.428H5.571C5.571,5.122,7.558,3.136,10,3.136 M16.865,16.864H3.136V8.45h13.729V16.864z M10,
            10.664c-0.854,0-1.55,0.696-1.55,1.551c0,0.699,0.467,1.292,1.107,1.485v0.95c0,0.243,0.2,0.442,0.443,0.442s0.443-0.199,
            0.443-0.442V13.7c0.64-0.193,1.106-0.786,1.106-1.485C11.55,11.36,10.854,10.664,10,10.664 M10,12.878c-0.366,
            0-0.664-0.298-0.664-0.663c0-0.366,0.298-0.665,0.664-0.665c0.365,0,0.664,0.299,0.664,0.665C10.664,12.58,10.365,12.878,10,12.878"></path>
                    </svg>
                    <input type="password" class="input100" name="password" placeholder="Password">
                    <span class="focus-input100" data-placeholder="&#xf18e;"></span>
                </div>
                <div class="wrap-input100 validate-input">
                    <svg class="svg-icon" viewBox="0 0 20 20">
                        <path d="M17.308,7.564h-1.993c0-2.929-2.385-5.314-5.314-5.314S4.686,4.635,4.686,7.564H2.693c-0.244,0-0.443,0.2-0.443,
            0.443v9.3c0,0.243,0.199,0.442,0.443,0.442h14.615c0.243,0,0.442-0.199,0.442-0.442v-9.3C17.75,7.764,17.551,7.564,17.308,
            7.564 M10,3.136c2.442,0,4.43,1.986,4.43,4.428H5.571C5.571,5.122,7.558,3.136,10,3.136 M16.865,16.864H3.136V8.45h13.729V16.864z M10,
            10.664c-0.854,0-1.55,0.696-1.55,1.551c0,0.699,0.467,1.292,1.107,1.485v0.95c0,0.243,0.2,0.442,0.443,0.442s0.443-0.199,
            0.443-0.442V13.7c0.64-0.193,1.106-0.786,1.106-1.485C11.55,11.36,10.854,10.664,10,10.664 M10,12.878c-0.366,
            0-0.664-0.298-0.664-0.663c0-0.366,0.298-0.665,0.664-0.665c0.365,0,0.664,0.299,0.664,0.665C10.664,12.58,10.365,12.878,10,12.878"></path>
                    </svg>
                    <input type="password" class="input100" name="repassword" placeholder="Re-Password">
                    <span class="focus-input100" data-placeholder="&#xf18e;"></span>
                </div>
                <div class="wrap-input100 validate-input">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                    </svg>
                    <input type="text" class="input100" name="email" placeholder="Email">
                    <span class="focus-input100" data-placeholder="&#xf18e;"></span>
                </div>
                <div class="wrap-input100 validate-input">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone" viewBox="0 0 16 16">
                        <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
                        <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                    </svg>
                    <input type="text" class="input100" name="phone" placeholder="Phone">
                    <span class="focus-input100" data-placeholder="&#xf18e;"></span>
                </div>
                <div class="wrap-input100 validate-input">
                    <svg class="svg-icon" viewBox="0 0 20 20">
                        <path d="M10,1.375c-3.17,0-5.75,2.548-5.75,5.682c0,6.685,5.259,11.276,5.483,11.469c0.152,0.132,0.382,0.132,0.534,0c0.224-0.193,
            5.481-4.784,5.483-11.469C15.75,3.923,13.171,1.375,10,1.375 M10,17.653c-1.064-1.024-4.929-5.127-4.929-10.596c0-2.68,2.212-4.861,
            4.929-4.861s4.929,2.181,4.929,4.861C14.927,12.518,11.063,16.627,10,17.653 M10,3.839c-1.815,0-3.286,1.47-3.286,3.286s1.47,3.286,
            3.286,3.286s3.286-1.47,3.286-3.286S11.815,3.839,10,3.839 M10,9.589c-1.359,0-2.464-1.105-2.464-2.464S8.641,4.661,10,4.661s2.464,
            1.105,2.464,2.464S11.359,9.589,10,9.589"></path>
                    </svg>
                    <input type="text" class="input100" name="address" placeholder="Address">
                    <span class="focus-input100" data-placeholder="&#xf18e;"></span>
                </div>
            </div>
            <div class="container-login100-form-btn">
                <button class="login100-form-btn" type="submit" name="submit" style="width : 90%; margin-left:20px;">Submit</button>
            </div>
        </form>
        <div class="link">
            <a href="login.php">Login</a>
        </div>
    </div>
</body>

</html>