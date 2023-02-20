const form = document.querySelector(".singup form"),
continueBtn =  form.querySelector(".button button"),
errorText =  form.querySelector(".error-txt");

form.onsubmit =(e)=>{
  e.preventDefault(); // preventing form from submitting
}


continueBtn.onclick = ()=>{
    let xhr=new XMLHttpRequest();
    xhr.open("POST","php/Singup.php", true);
    xhr.onload=()=>{
        if(xhr.readyState=== XMLHttpRequest.DONE){
            if(xhr.status===200){
                let data= xhr.response;
                console.log(data)
                if(data === "success")
                {
                    location.href = 'singin.php'; /*users.php*/
                }
                else
                {
                    document.getElementById("load").innerHTML = 'Sing up';
                    errorText.textContent=data;
                    errorText.style.display="block";
                    
                }
            }
        }
    }
    document.getElementById("load").innerHTML = 'Please wait...';
    let formData= new FormData(form)
    xhr.send(formData);
}