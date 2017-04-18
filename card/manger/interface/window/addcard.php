<?php
 include_once dirname(dirname(dirname(dirname(__FILE__)))).'/module/mysqlaction.php';
 $sql="select fname from bw_cardtype";
 $dataResult = loaddb($sql);
    //echo $totalResultSql.$sumSqlWhere.$orderSql.$limitSql;
   
 ?>
<h1><span class="mif-windows"> 新建卡片</h1>
                       <label>卡片类型：</label>
                        <div class="input-control select full-size">
                            <select id="s">
                                <?php
                                 while ($row = mysqli_fetch_array($dataResult)) {
       echo "<option>".$row['fname']."</option>";
                                  }
    ?>
                            </select>
                        </div>
                        <label>要生成的数量:</label>
                        <div class="input-control text full-size">
                            <input type="text" id="n">
                        </div>
                    <button class="button" onclick="don();">生成</button><BR>
                    <label>生成区：</label>
                        <div class="input-control textarea full-size">
                            <textarea id="t" ></textarea>
                        </div>
                        <script>
                            function don(){
                             var s = $('#s').val();
                              var n = $('#n').val();
                             
                              if(!isNaN(n)){
                                   n=n-1;
                                    $.post('query/todo.php?r='+Math.random(), {num:n,cardtype:s,type:"makecard" }, function (text, status) {
$("#t").val(text);
                                    });

                              }else{
                                  alert('输入值非法！');
                                  return 0;
                              }
                            }
                         </script>
