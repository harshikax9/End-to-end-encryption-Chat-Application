const form= document.querySelector(".typing-area"),
inputField=form.querySelector(".input_field"),
sendBtn = form.querySelector("button"),
chatBox=document.querySelector(".chat-box");

form.onsubmit= (e)=>{
    e.preventDefault(); // preventing form from submitting
}

sendBtn.onclick = ()=>{
    
    let xhr=new XMLHttpRequest();
    xhr.open("POST","php/insert-chat.php", true);
    xhr.onload=()=>{
        if(xhr.readyState=== XMLHttpRequest.DONE){
            if(xhr.status===200){
                inputField.value= ""; //once message inserted into database then leave blank the input field
                scrollToBottom();
            }
        }
    }

     let formData= new FormData(form)
    xhr.send(formData);
}

chatBox.onmouseenter = ()=>{
    chatBox.classList.add("active");
}

chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active");
}

setInterval(()=>{
    let xhr=new XMLHttpRequest();
    xhr.open("POST","php/get-chat.php", true);
    xhr.onload=()=>{
        if(xhr.readyState=== XMLHttpRequest.DONE){
            if(xhr.status===200){
                let data= xhr.response;
                chatBox.innerHTML=data;
               if(!chatBox.classList.contains("active")){ // if active class not contain in chatbox the scroll to bottom
                scrollToBottom();
               }
               
            }
        }
    }

    let formData= new FormData(form)
    xhr.send(formData);

},500); //this funtion will run frequently after 500ms


function scrollToBottom(){
    chatBox.scrollTop =chatBox.scrollHeight;
}