<!DOCTYPE html>
<html dir="ltr">
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <?php 
        echo $this->Html->meta('favicon.ico','/img/favicon.png',array('type' => 'icon'));
        echo $this->fetch('meta');
        echo $this->fetch('author');
        echo $this->Html->meta('title');
        //Facebook Meta
        echo $this->fetch('fb:page_id');
        echo $this->fetch('og:url');
        echo $this->fetch('og:image');
        echo $this->fetch('og:description');
        echo $this->fetch('og:title');
        echo $this->fetch('og:type');
        
        //Google Meta
        echo $this->fetch('google_name');
        echo $this->fetch('google_description');
        echo $this->fetch('google_image');
    ?>
	<?php echo $this->fetch('css') ?>
    <link class="" href='//fonts.googleapis.com/css?family=Open+Sans:300,300italic,regular,italic,600,600italic,700,700italic,800,800italic&subset=latin' rel='stylesheet' type='text/css'>
    <meta charset="utf-8">
    <meta name="keywords" content="HTML, CSS, JavaScript">

</head>
	<body>
		<div class="wrapper">
			<div id="content" class="bg-container">
				<?= $this->fetch('content')?>
			</div>
		</div>
		<?= $this->fetch('script')?>
	</body>
</html>


