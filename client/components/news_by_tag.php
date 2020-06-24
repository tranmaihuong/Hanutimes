<?php
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}
$id = $_GET['id'];
$url = "http://localhost/hanutimes/webservices/api/get_all_news_by_tags.php?id=$id&&page=$page";

$news = curl_init($url);
curl_setopt($news, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($news);

$result = json_decode($response, true);
$total_page = $result[0]['total_page'];

?>

<?php
if ($result['message'] != NULL) {
    echo $result['message'];
} else {
    foreach ($result as $key => $value) : ?>
        <div class="case">
            <div class="row">
                <div class="col-md-6 col-lg-6 col-xl-6 d-flex">
                    <a href='news_single.php?id=<?php echo $value['news_id']; ?>' class="img w-100 mb-3 mb-md-0" style="background-image: url('images/news-pics/pic (<?php echo $value['pic']; ?>).jpg');">
                    </a>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-6 d-flex">
                    <div class="text w-100 pl-md-3">
                        <span class="subheading"><?php echo $value['author']; ?> </span>
                        <div class="meta">
                            <?php $date = explode('-', $value['created_date']); ?>
                            <?php
                            $day = $date[2];
                            $mos = date("F", mktime(0, 0, 0, $date[1], 10));
                            $yr = $date[0];
                            ?>

                            <p class="mb-1"><?php echo $mos . ' ' . $day . ', ' . $yr ?></p>
                        </div>
                        <h3 class="heading mb-3"><a href='news_single.php?id=<?php echo $value['news_id']; ?>'><?php echo $value['title']; ?></a></h3>
                        <p><?php echo $value['short_intro']; ?></p>
                        <p> <a href='news_single.php?id=<?php echo $value['news_id']; ?>' class="btn-custom"><span class="ion-ios-arrow-round-forward mr-3"></span>Read more</a></p>



                    </div>
                </div>
            </div>
        </div>
<?php endforeach;
} ?>


<div class="row mt-5">
    <div class="col text-center">
        <div class="block-27">
            <?php 
            $range = 5; // Số trang hiển thị
            $pagelimit = ($range - 1) / 2; // Phân chia hiển thị , ví dụ số được chọn ở giữa
            $pagemax = $range;
            if ($page - $pagelimit < 1) {
                if ($total_page < $range) // Dành cho cái số trang nhỏ hơn số trang hiển thị sẽ không chạy từ 1 -  đến tổng số trang hiển thị
                {
                    $pagemax = $total_page;
                }
                $pagemin = 1;
            } else {
                if ($page + $pagelimit <= $total_page) {
                    $pagemin = $page - $pagelimit;
                    $pagemax = $page + $pagelimit;
                }
                if ($page + $pagelimit > $total_page) {
                    if ($total_page < $range) // Trường hợp số trang nhỏ hơn số trang hiển thị 
                    {
                        $pagemin = 1;
                        $pagemax = $sotrang;
                    } else {
                        $pagemin = $total_page - $range + 1;
                        $pagemax = $total_page;
                    }
                }
            }
            if ($page + $pagelimit > $total_page) {
                $pagemax = $total_page;
            } ?>
            <ul>
                <li class="prev-btn" <?php if ($page == $pagemin) echo 'style = "display: none;"' ?>><a href="tag.php?id=<?php echo $id ?>&&page=<?php echo ($page - 1); ?>">&lt;</a></li>
                <?php if ($pagemin != 1) {
                    echo '<li><a href=# style="border: none;">. . .</a></li>';
                } ?>
                <?php for ($i = $pagemin; $i <= $pagemax; $i++) { ?>
                    <li <?php if ($page == $i) echo "class='active'"; ?>>
                        <a href="tag.php?id=<?php echo $id; ?>&&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
                <?php if ($pagemax != $total_page) {
                    echo '<li><a href=# style="border: none;">. . .</a></li>';
                } ?>
                <li class="next-btn" <?php if ($page >= $pagemax) echo 'style = "display: none;"' ?>><a href="tag.php?id=<?php echo $id; ?>&&page=<?php echo ($page + 1); ?>">&gt;</a></li>

            </ul>
        </div>
    </div>
</div>