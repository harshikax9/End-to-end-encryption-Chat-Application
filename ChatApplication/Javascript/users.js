const searchbar=document.querySelector(".users .Search input"),
searchBtn=document.querySelector(".users .Search button"),
userList=document.querySelector(".users .user-list");

searchBtn.onclick=()=>{
    searchbar.classList.toggle("active");
    searchbar.focus(); 
    searchBtn.classList.toggle("active")

}
searchbar.onkeyup=()=>{
    let searchTerm=searchbar.value;

    if(searchTerm != "")
    {
        searchbar.classList.add("active");
    }
    else
    {
        searchbar.classList.remove("active");
    }
    let xhr=new XMLHttpRequest();
    xhr.open("POST","php/Search.php", true);
    xhr.onload=()=>{
        if(xhr.readyState=== XMLHttpRequest.DONE){
            if(xhr.status===200){
                let data= xhr.response;
                userList.innerHTML=data;
               
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchTerm=" + searchTerm);
}
setInterval(()=>{
    let xhr=new XMLHttpRequest();
    xhr.open("GET","php/users.php", true);
    xhr.onload=()=>{
        if(xhr.readyState=== XMLHttpRequest.DONE){
            if(xhr.status===200){
                let data= xhr.response;
               if(!searchbar.classList.contains("active")) // if active not contains in search bar then add this data
               userList.innerHTML=data;
               //console.log(data);
            }
        }
    }

    xhr.send();
},500); //this funtion will run frequently after 500ms