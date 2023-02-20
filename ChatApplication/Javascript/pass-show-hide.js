const pswrdFiel=document.querySelector(".form input[type='password']"),
toggleBtn =document.querySelector(".form .field i");

toggleBtn.onclick=()=>{
    if(pswrdFiel.type =="password")
    {
        pswrdFiel.type = "text";
        toggleBtn.classList.add("active");
    }
    else
    {
        pswrdFiel.type = "password";
        toggleBtn.classList.remove("active");
    }
}