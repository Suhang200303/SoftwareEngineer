document.getElementById('imageInput').addEventListener('change', function(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const preview = document.getElementById('preview');
        preview.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
});

document.getElementById('uploadForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData();
    const imageFile = document.getElementById('imageInput').files[0];
    formData.append('image', imageFile);

    fetch('./php/imgsimiation.php', {
        method: 'POST',
        body: formData
    })

    .then(response => response.json())
    .then(data => {
        console.log("ready"); // 在控制台输出返回的数据
        console.log(data); // 在控制台输出返回的数据
        const resultList = document.getElementById('resultList');
        resultList.innerHTML = '';
        if (data.result && data.result.length > 0) {
            data.result.forEach(item => {
                const listItem = document.createElement('li');
                listItem.textContent = `${item.name} - 置信度: ${item.score}`;
                resultList.appendChild(listItem);
            });
        } else {
            resultList.textContent = '没有识别结果。';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const resultList = document.getElementById('resultList');
        resultList.textContent = '识别过程中发生错误。';
    });
});