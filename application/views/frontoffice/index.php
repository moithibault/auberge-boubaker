<article>
 <header>
<h1><?= $section->title ?></h1>
</header>
<section>
<p> <?= $section->content ?></p>
</section>

</article>
<?php
if(!empty($photos) || !empty($section->aside)){
    echo '<aside>';
    echo $section->aside;
    if(!empty($photos)){
        echo '<hr/>';
        foreach($photos AS $photo){
            echo '<a href="'.base_url().'assets/upload/original/'.$photo->id.$photo->extension.'" class="swipebox" title="'.$photo->title.'">
            <img src="'.base_url().'assets/upload/thumbnail/'.$photo->id.$photo->extension.'" alt="'.$photo->title.'"/>
            </a>';
         }
    }
    echo '</aside>';
}

?>