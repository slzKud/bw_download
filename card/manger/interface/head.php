<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $pagetitle; ?></title>
    <link href="../css/metro.css" rel="stylesheet">
    <link href="../css/metro-icons.css" rel="stylesheet">
    <link href="../css/metro-responsive.css" rel="stylesheet">
    <script src="../js/jquery-2.1.3.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/metro.js"></script>
    <style>
        html, body {
            height: 100%;
        }
        body {
        }
        .page-content {
            padding-top: 3.125rem;
            min-height: 100%;
            height: 100%;
        }
        .table .input-control.checkbox {
            line-height: 1;
            min-height: 0;
            height: auto;
        }

        @media screen and (max-width: 800px){
            #cell-sidebar {
                flex-basis: 52px;
            }
            #cell-content {
                flex-basis: calc(100% - 52px);
            }
        }
    </style>

    <script>
        function pushMessage(t){
            var mes = 'Info|Implement independently';
            $.Notify({
                caption: mes.split("|")[0],
                content: mes.split("|")[1],
                type: t
            });
        }

        $(function(){
            $('.sidebar').on('click', 'li', function(){
                if (!$(this).hasClass('active')) {
                    $('.sidebar li').removeClass('active');
                    $(this).addClass('active');
                }
            })
        })
    </script>
</head>
<body class="bg-steel">
    <div class="app-bar fixed-top darcula" data-role="appbar">
        <a class="app-bar-element branding">BetaWorld充值卡平台</a>
        <span class="app-bar-divider"></span>
        <ul class="app-bar-menu">
            <li><a href="">仪表盘</a></li>
            <li><a href="">返回资源区管理站</a></li>
        </ul>

        <div class="app-bar-element place-right">
            <span class="dropdown-toggle"><span class="mif-cog"></span> Kud</span>
            <div class="app-bar-drop-container padding10 place-right no-margin-top block-shadow fg-dark" data-role="dropdown" data-no-close="true" style="width: 220px">
                <ul class="unstyled-list fg-dark">
                    <li><a href="" class="fg-white3 fg-hover-yellow">退出登录</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="flex-grid no-responsive-future" style="height: 100%;">
            <div class="row" style="height: 100%">
                <div class="cell size-x200" id="cell-sidebar" style="background-color: #71b1d1; height: 100%">
                    <ul class="sidebar">
                        <li <?php if($pagenum==1){echo 'class="active"';}?>><a href="index.php">
                            <span class="mif-apps icon"></span>
                            <span class="title">仪表盘</span>
                            <span class="counter">0</span>
                        </a></li>
                         <li <?php if($pagenum==6){echo 'class="active"';}?>><a href="cardtypemanger.php">
                            <span class="mif-vpn-publ icon"></span>
                            <span class="title">卡片种类管理</span>
                            <span class="counter">0</span>
                        </a></li>
                         <li <?php if($pagenum==2){echo 'class="active"';}?>><a href="cardmanger.php">
                            <span class="mif-vpn-publ icon"></span>
                            <span class="title">卡片管理</span>
                            <span class="counter">0</span>
                        </a></li>
                        <li <?php if($pagenum==3){echo 'class="active"';}?>><a href="cardhistory.php">
                            <span class="mif-vpn-publ icon"></span>
                            <span class="title">充值记录</span>
                            <span class="counter">0</span>
                        </a></li>
                        <li <?php if($pagenum==4){echo 'class="active"';}?> ><a href="plfk.php">
                            <span class="mif-apps icon"></span>
                            <span class="title">批量生成卡片</span>
                            <span class="counter">0</span>
                        </a></li>
                        <li <?php if($pagenum==5){echo 'class="active"';}?> ><a href="bwset.php">
                            <span class="mif-cloud icon"></span>
                            <span class="title">对接资源区设置</span>
                            <span class="counter">0</span>
                        </a></li>
                        
                    </ul>
                </div>
                <div class="cell auto-size padding20 bg-white" id="cell-content">
