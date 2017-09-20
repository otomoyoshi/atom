<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Intro.js Demo</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.1.0/intro.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.1.0/introjs.min.css" rel="stylesheet" type="text/css">
</head>
<body style="padding:15px;">
  <h1><i class="fa fa-play-circle" style="font-size:1em;"></i> intro.js Test</h1>
  <form name="users">
    <select name="testSelect" id="hige" data-intro="higeを選択してください" data-step="1">
      <option value="opt1">value1</option>
      <option value="opt2">value2</option>
      <option value="opt3">value3</option>
    </select>
    <input type="text" name="hoge" id="hoge" class="hogeInput" placeholder="hoge"  data-intro="hogeを入力してください" data-step="2" />
    <input type="button" name="hage" id="hage" class="hageInput" placeholder="hage"  data-intro="登録ボタンを押してください" data-step="3" value="登録" />
  </form>
  <script type="text/javascript">
  introJs().start();
  </script>
</body>
</html>