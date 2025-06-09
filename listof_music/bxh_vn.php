<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th> </th>
                <th> </th>
                <th> </th>
            </tr>
        </thead>
        <tbody>
            <?php 
            include("./listof_music/connect.php");
            mysqli_set_charset($connect,'utf8');
            $query = mysqli_query($connect, "SELECT * FROM `baihat`,`casi` WHERE baihat.id_casi = casi.id_casi and baihat.theloai in (N'Nhạc trẻ',N'Nhạc Đỏ', N'Nhạc Rap') ORDER by baihat.luotnghe DESC;");
            $count = 0;
            while ($row = mysqli_fetch_assoc($query)){
                $count++;
                ?>
                <tr>
                    <td <?php
                        if ($count == 1) {
                            echo 'style="background-color: red;"';
                        }
                        else if ($count == 2) {
                            echo 'style="background-color: orange;"';
                        }
                        else if ($count == 3) {
                            echo 'style="background-color: yellow;"';
                        }
                    ?>><div class="song-number" ><?php echo $count; ?></div></td>
                    <td class="songs">
                        <div class="song-info">
                            <div>
                                <strong><a href="<?php echo $row['linknhac']; ?>"><?php echo $row['tenbaihat']; ?></a></strong>
                            </div>
                            <div>
                                <?php echo $row['tenCaSi']; ?>
                            </div>
                        </div>
                    </td>
                    <td class="views">
                       <strong> <?php echo $row['luotnghe']; ?></strong>
                       <?php echo " Views"; ?>
                    </td>
                </tr>
                <?php
                    if ($count == 10){
                        break;
                    }
            }
    ?>
        </tbody>
    </table>
</body>
</html>