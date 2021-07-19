<?php
/*
 * Created on Mon Jul 19 2021
 *
 * The MIT License (MIT)
 * Copyright (c) 2021 MartDevelopers Inc
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial
 * portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

session_start();
require_once('../config/config.php');

if (isset($_POST['Login'])) {
    $Login_username = $_POST['Login_username'];
    $Login_password = sha1(md5($_POST['Login_password']));
    $Login_rank = $_POST['Login_rank'];

    $stmt = $mysqli->prepare("SELECT Login_username, Login_password, Login_rank, Login_id  FROM login  WHERE Login_username =? AND Login_password =? ");
    $stmt->bind_param('ss', $Login_username, $Login_password);
    $stmt->execute(); //execute bind

    $stmt->bind_result($Login_username, $Login_password, $Login_rank, $Login_id);
    $rs = $stmt->fetch();
    $_SESSION['Login_id'] = $Login_id;
    $_SESSION['Login_rank'] = $Login_rank;

    /* Decide Login User Dashboard Based On User Rank */
    if ($rs && $Login_rank == 'Administrator') {
        header("location:home");
    } else if ($rs && $Login_rank == 'Student') {
        header("location:student_dasboard");
    } else {
        $err = "Login Failed, Please Check Your Credentials And Login Permission ";
    }
}
require_once('../partials/head.php');
?>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href=""><b>Job Portal Management System</b></a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="Login_username" class="form-control" placeholder="Login Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user-tag"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="Login_password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <p class="mb-0 text-center">
                        Login In As
                    </p>


                    <div class="row">
                        <div class="col-8">
                            <div class="input-group mb-3">
                                <select name="Login_rank" class="form-control">
                                    <option>Admninistrator</option>
                                    <option>Student</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" name="Login" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>

                <p class="mb-1">
                    <a href="forget_password">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="register" class="text-center">Register a student account</a>
                </p>
            </div>
        </div>
    </div>
    <?php require_once('../partials/scripts.php'); ?>

</body>

</html>