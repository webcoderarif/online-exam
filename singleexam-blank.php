<?php
    require_once 'init.php';
    $all = new All();
    $exam = new Exam();
    $common = new Common();
?>
<?php
   $exam_id = Session::get('exmid');
   $sub = $common->select("`add_exam`","`id`='$exam_id'");
   
   $raw = mysqli_fetch_assoc($sub);

    if(isset($_GET['q'])){
        $sid = $_GET['q'];
        $serial = $common->select("`questions`","`exam_id` = '$exam_id' && `serial` = '$sid'");
        $result = mysqli_fetch_assoc($serial);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
        $process=$exam->ExamProcess($_POST,$exam_id);
    }
    
    if(isset($_SESSION['exam_sheet'])) {
        foreach ($_SESSION['exam_sheet'] as $key => $value) {
            echo $key . ' = ' . $value . '<br>';
        }
    }

?>

<DOCTYPE html>
  <html>
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="utf-8" />
    </head>
    <style>
        body{
        background:url(image/start.jpg) repeat fixed 0 0 #000;position: relative;
        }
    </style>
    <body>
      <div class="container">
          <div class="main mx-auto mb-1 shadow-sm p-3 mb-5 bg-light rounded" style= "width:800px; margin-top: 35;">
                <div class="exam_head my-1">
                    <div class="text-center">
                        <h4 class="text-muted"><strong><?=$raw['examname']?></strong></h4>
                        <h4 class="text-muted"><strong>Sub:<?=$raw['subjectname']?></strong></h4>
                    </div>
                    
                    <div class="row mx-1">
                        <div class="col-4">
                            <h4 class="text-muted">Time:<?=$raw['duration']?> minute</h4>
                        </div>
                        <div class="col-4">
                            <h4 class="text-muted">Quetion:<?=$raw['tquetion']?></h4>
                        </div>
                        <div class="col-4">
                            <h4 class="text-muted"><?=$raw['exmdate']?></h4>
                        </div>
                    </div>
                
                </div>
                <hr>
                <div class="exam_body">
                    <div class="row">
                        <form action = "" method = "post">
                            <div class="col-12">
                                <div class="mb-1  p-1 ">
                                    <h3><?=$result['question']?></h3>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                <input type="radio" id="ans" name="ans" value="option_one"/>
                                    <?=$result['option_one']?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                <input type="radio" id="ans" name="ans" value="option_two"/>
                                    <?=$result['option_two']?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                <input type="radio" id="ans" name="ans" value="option_three"/>
                                    <?=$result['option_three']?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                <input type="radio" id="ans" name="ans"  value="option_four"/>
                                    <?=$result['option_four']?>
                                </div>  
                            </div>
                            <div class="mt-1">
                                <input type = "submit" class="btn btn-success" name = "submit" value = "Next Quetion" />
                                <input type = "hidden" value = "<?php echo $sid ;?>" name = "serial" id = "serial"/>

                                <input type="hidden" value="<?= $result['id']; ?>" name="q_id"/>
                                
                                <input type = "hidden" value = "<?php echo $exam_id  ;?>" name = "" id = "xmid"/>

                            </div>
                        </form>
                        
                            
                        
                    </div>
                </div>
            </div>

      </div>

      
      
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"   crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        
        <script src="admin/assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="admin/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function (){
                $("#submit").click(function(){
                    var ans     = $("#ans").val();
                    var serial = $("#serial").val();
                    var xmid = $("#xmid").val();
                   
                    var dataString ='ans='+ans+'&serial='+serial+'&xmid='+xmid;
                    $.ajax({
                        type:"POST",
                        url:"admin/ajax/exam-process.php",
                        data:"dataString",
                        success:function(data){
                        }
                      
                    });
                    return false;
                });


            });
        </script>
    </body>
</html>