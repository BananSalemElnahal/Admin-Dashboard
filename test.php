<?php
$password_input = "123456";  // كلمة المرور التي تريد التحقق منها
$stored_hash = "$2y$10$3kR1IY5DTBGAwR8q/Wv3luiNVnquuBUVrA0yfkmvgdgiz6lYzh9yy";  // التجزئة المخزنة في قاعدة البيانات

if (password_verify($password_input, $stored_hash)) {
    echo "✅ كلمة المرور صحيحة!";
} else {
    echo "❌ كلمة المرور غير صحيحة!";
}



// إذا كانت كلمة المرور المشفرة مخزنة في قاعدة البيانات في عمود 'password'
$stored_password = '$2y$10$z0nv0NLBwpQENlfsdZmz7Oo3.oW00z9zYZ9.9fN9Tt9G5xyJtZIqe'; // هذا هو الباسورد المشفر من قاعدة البيانات
$input_password = '12345678'; // كلمة المرور المدخلة من المستخدم

if (password_verify($input_password, $stored_password)) {
    echo "كلمة المرور صحيحة!";
} else {
    echo "كلمة المرور غير صحيحة.";
}

?>
