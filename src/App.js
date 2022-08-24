import React, { useState, useRef } from 'react';


const App = () => {
  
  const[response, setResponse] = useState("")
  const [name, setname] = useState("");
  const selectedFile = useRef();
  
  const retriever=async()=>{
    var xhr = new XMLHttpRequest()
    xhr.open('POST', 'http://localhost/might-work-please/upload.php', true);
    xhr.setRequestHeader("Content-type", "application/x-ww-form-urlencoded")
    xhr.onload = function(){
      console.log(JSON.parse(this.responseText))
    };

    xhr.send(`fetch`)
  }

  const uploader = async () => {
    if(name === ""){
      setResponse("name input cannot be empty");
    }
    if (selectedFile.current.files.length === 0){
      setResponse("please chose an image")
    }else{
      const formData = new FormData()
      formData.append("picture", selectedFile.current.files[0])
      formData.append("name", name)

      var xhr = new XMLHttpRequest();
      xhr.open("POST", "http://localhost/might-work-please/upload.php", true);

      xhr.onload = function () {
        if(this.responseText==="success"){
          retriever();
        }
        console.log(this.responseText)
      };

      xhr.send(formData);
    }
  };

  return (
    <div>
      <p>{response}</p>
      <input type="text" onChange = {(e) => setname(e.target.value)}/>
      <input type="file" ref={selectedFile}/>
      <button onClick={uploader}>upload</button>
    </div>
  );
}

export default App;
