<?php 
$pagenum=3;
$pagetitle="充值记录";
include dirname(__FILE__).'/interface/head.php';
?>

                    <h1 class="text-light">充值记录<span class="mif-drive-eta place-right"></span></h1>
                    <hr class="thin bg-grayLighter">
                    <table class="striped cell-hovered " data-role="datatable" data-auto-width="false">
                        <thead>
                        <tr>
                            <td style="width: 20px">
                            </td>
                            <td class="sortable-column">充值日期</td>
                            <td class="sortable-column">卡号</td>
                            <td class="sortable-column">卡片类型</td>
                            <td class="sortable-column">充值到的账户</td>
                            <td class="sortable-column">充值结果</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <label class="input-control checkbox small-check no-margin">
                                    <input type="checkbox">
                                    <span class="check"></span>
                                </label>
                            </td>
                            <td>2017-06-07 09:00:00</td>
                            <td>BW88SDF5FVSPC</td>
                            <td>30元公共区100G</td>
                            <td>Kud</a></td>
                            <td>充值成功</a></td>
                         
                        </tr>
                        <tr>
                            <td>
                                <label class="input-control checkbox small-check no-margin">
                                    <input type="checkbox">
                                    <span class="check"></span>
                                </label>
                            </td>
                            <td>2017-07-21 00:00:00</td>
                            <td>BW85GDFRDESBS</td>
                            <td>999元B-side100G</td>
                            <td>Tester</a></td>
                            <td>充值失败：用户不存在</a></td>
                        </tr>
                        </tbody>
                    </table>
             
<?php
include dirname(__FILE__).'/interface/foot.php';
?>