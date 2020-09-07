<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>upload single</title>
  </head>
  <body>
    <form action="">
      <button type="button" onclick="file_input.click()">上傳圖一</button>
      <input type="hidden" id="field1" name="field1" />
      <img src="" alt="" id="myimg" width="250px" />
      <br />
    </form>

    <input type="file" id="file_input" style="display: none" />

    <script>
      const file_input = document.querySelector("#file_input");
      const field1 = document.querySelector("#field1");
      file_input.addEventListener("change", (event) => {
        console.log(file_input.file);
        const fd = new FormData();
        fd.append("myfile", file_input.files[0]);

        fetch("upload-single-api.php", {
          method: "post",
          body: fd,
        })
          .then((r) => r.json())
          .then((obj) => {
            field1.value = obj.filename;
            document.querySelector("#myimg").src = "./photo/" + obj.filename;
          });
      });
    </script>
  </body>
</html>
