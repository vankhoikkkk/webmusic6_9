<?php
include_once "DAO/AdsDAO.php";

$adsDAO = new AdsDAO();
$ad = $adsDAO->getActiveAd();

if ($ad && $ad->num_rows > 0):
    $row = $ad->fetch_assoc();
?>
<link rel="stylesheet" href="CSS/Ads.css?v=<?= time(); ?>">

<div id="ad-banner">
    <a href="<?= $row['target_url'] ?>" target="_blank" rel="noopener noreferrer">
        <img src="<?= $row['image_url'] ?>" alt="<?= $row['title'] ?>">
    </a>
    <button onclick="document.getElementById('ad-banner').style.display='none'">×</button>
</div>

<script>
    setTimeout(() => {
        const banner = document.getElementById('ad-banner');
        if (banner) banner.style.display = 'none';
    }, 5000);
</script>
<?php endif; ?>