
document.addEventListener('DOMContentLoaded', function () {
    var eye = document.getElementById('eye');
    var pwd = document.getElementById('pwd');
    if (eye) {
        eye.addEventListener('click', togglePass);
    }
    let rememberUser = localStorage.getItem('rememberMe');
    document.form1.id.value = rememberUser;
    let rememberUserCheck = localStorage.getItem('rememberMeCheck');
    if(rememberUserCheck == 1)
        document.form1.customCheck1.checked = true;
    $("#btnLogin").on("click", e=>{
        checkStuff();
    })
});

function togglePass(){

   eye.classList.toggle('active');

   (pwd.type == 'password') ? pwd.type = 'text' : pwd.type = 'password';
}

// Form Validation

function checkStuff() {
  var id = document.form1.id;
  var password = document.form1.password;
  var msg = document.getElementById('msg');
  
  if (id.value == "") {
    msg.style.display = 'block';
    msg.innerHTML = "아이디를 입력하세요";
    id.focus();
    return false;
  } else {
    msg.innerHTML = "";
  }
  
   if (password.value == "") {
    msg.style.display = 'block';
    msg.innerHTML = "비밀번호를 입력하세요";
    password.focus();
    return false;
  } else {
    msg.innerHTML = "";
  }   
  login();
}



function login(){
   
    let isRememberMe = $(".btn-remember-me").is(":checked");
    let id = document.form1.id.value;
    let password = document.form1.password.value;

    if(isRememberMe){
        localStorage.setItem('rememberMe', id);
        localStorage.setItem('rememberMeCheck', 1);
    }else{
        localStorage.removeItem('rememberMe');
        localStorage.removeItem('rememberMeCheck');        
    }
    // console.error({identity, password});
    axios.post('/login', {identity:id, password}).then(res=>{
       
        if(res.data.status == "success"){
            window.location.href = res.data.redir;
        }else{
            var msg = document.getElementById('msg');
            msg.style.display = 'block';
            msg.innerHTML = "아이디와 비밀번호가 정확하지 않습니다.";
            document.form1.password.select();
        }
    })
}
// ParticlesJS

// ParticlesJS Config.
