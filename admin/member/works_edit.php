<?php
require_once '../../php/db.php';
require_once '../../php/functions.php';
require_once '../../php/works.php';

if (!isset($_SESSION['is_login']) || !$_SESSION['is_login']) {
	header("Location: ../../login.php");
}
$datass = get_user();
$data = get_edit_works($_GET['i']);
?>

<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>SHUSTART</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,600,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../../css/icomoon-social.css">
    <link rel="stylesheet" href="../../css/leaflet.css" />
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="shortcut icon" href="../../img/icon.png" />
    <script src="../../js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>
<body>
    <?php include_once 'menu.php'?>

    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>作品編輯</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="main">
        <div class="section">
            <div class="container">
                <div class="row add_btn_area">
                    <div class="col-xs-12">
                        <form id="edit_works_form">
						 <input type="hidden" id="id" value="<?php echo $data['id'];?>">
                            <div class="form-group">
                                <label for="title">標題</label>
                                <input type="text" class="form-control" id="title" placeholder="請輸入標題" value="<?php echo $data['title'];?>">
                            </div>
                            <div class="form-group">
                                <label for="intro">簡介</label>
                                <textarea type="text" class="form-control" id="intro" rows="5"><?php echo $data['intro'];?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="content">內容</label>
                                <textarea type="text" class="form-control" id="content" rows="10"><?php echo $data['content'];?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="subject"><b>系所</b></label>
                                <select name="subject" id="subject" required>
                                    <option value="">請選擇</option>
                                    <option value="1" <?php echo ($data['subject'] == "1")?'selected':'';?>>廣電系</option>
                                    <option value="2" <?php echo ($data['subject'] == "2")?'selected':'';?>>新聞系</option>
                                    <option value="3" <?php echo ($data['subject'] == "3")?'selected':'';?>>公廣系</option>
                                    <option value="4" <?php echo ($data['subject'] == "4")?'selected':'';?>>圖傳系</option>
                                    <option value="5" <?php echo ($data['subject'] == "5")?'selected':'';?>>資傳系</option>
                                    <option value="6" <?php echo ($data['subject'] == "6")?'selected':'';?>>口傳系</option>
                                    <option value="7" <?php echo ($data['subject'] == "7")?'selected':'';?>>傳管系</option>
                                    <option value="8" <?php echo ($data['subject'] == "8")?'selected':'';?>>數媒系</option>
                                    <option value="9" <?php echo ($data['subject'] == "9")?'selected':'';?>>資管系</option>
                                    <option value="10" <?php echo ($data['subject'] == "10")?'selected':'';?>>企管系</option>
                                    <option value="11" <?php echo ($data['subject'] == "11")?'selected':'';?>>觀光系</option>
                                    <option value="12" <?php echo ($data['subject'] == "12")?'selected':'';?>>英語系</option>
                                    <option value="13" <?php echo ($data['subject'] == "13")?'selected':'';?>>日文系</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="category">分類</label>
                                <select id="category" class="form-control" required>
                                    <option value="">請選擇</option>
                                    <option value="1" <?php echo ($data['category'] == 1)?'selected':'';?>>畢業展</option>
                                    <option value="2" <?php echo ($data['category'] == 2)?'selected':'';?>>傳技展</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="video_path">影片網址</label>
                                <input class="form-control" id="video_path" value="<?php echo $data['video_path'];?>" required>
								<br>
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/khUki6IPjfk" frameborder="0" allowfullscreen></iframe>
								</div>
                            </div>
                            <div class="form-group">
                                <label class="radio-inline">
                                    <input type="radio" name="publish" value="1" <?php echo ($data['publish'] == 1)?'checked':'';?>>
                                    發佈
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="publish" value="0" <?php echo ($data['publish'] == 0)?'checked':'';?>>
                                    不發佈
                                </label>
                            </div>
                            <button type="submit" class="btn btn-default">
                                送出
                            </button>
                            <div class="loading text-center"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'footer.php'?>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
        $(document).on("ready", function () {
            $("#edit_works_form").on("submit", function () {

                if ($("#title").val() == '' || $("#intro").val() == '') {
                    alert("請填入標題或簡介");

                } else {
                    $.ajax({
                        type: "POST",
                        url: "../../php/update_works.php", 
                        data: {
							'id': $("#id").val(),
                            'title': $("#title").val(),
                            'intro': $("#intro").val(),
                            'content': $("#content").val(),
                            'subject': $("#subject").val(),
                            'category': $("#category").val(),
                            'video_path': $("#video_path").val(),
                            'publish': $("input[name='publish']:checked").val()
                        },
                        dataType: 'html'
                    }).done(function (data) {
                        if (data == "yes") {
                            alert("新增成功，點擊確認回列表");
                            window.location.href = "works_list.php";
                        } else {
                            alert("新增錯誤");
                        }

                    }).fail(function (jqXHR, textStatus, errorThrown) {
                        alert("有錯誤產生，請看 console log");
                        console.log(jqXHR.responseText);
                    });
                }
                return false;
            });
        });
    </script>
    <!--JavaScript-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="../js/jquery-1.9.1.min.js"><\/script>')
    </script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/jquery.fitvids.js"></script>
    <script src="../../js/jquery.sequence-min.js"></script>
    <script src="../../js/jquery.bxslider.js"></script>
    <script src="../../js/main-menu.js"></script>
    <script src="../../js/template.js"></script>
    <script src="http://cdn.leafletjs.com/leaflet-0.5.1/leaflet.js"></script>
</body>
</html>