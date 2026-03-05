<?php
// Same database query as before
?>

<style>
.simple-slider {
    position: relative;
    max-width: 500px;
    margin: 0 auto;
}
.slide {
    display: none;
    text-align: center;
}
.slide.active {
    display: block;
}
.slide img {
    max-height: 400px;
    width: auto;
    max-width: 100%;
}
.slider-nav {
    text-align: center;
    margin-top: 10px;
}
.slider-nav button {
    margin: 0 5px;
}
</style>

<div class="container-fluid" style="padding-top:10px;background-color:lightgrey;">

<?php $selqry = "select * from mas_customer where customer_Id = '".$ID."'";

$sel = $this->db->query($selqry)->result_array();

$filecount = count($sel);

?>
    
    <?php if ($filecount > 0){ ?>
        <div class="simple-slider">
            <?php 
            $i = 1;
            foreach ($sel as $file) {
                $filename = $file['Photopath'];
                $image_url = scs_url . $filename;
            ?>
                <div class="slide <?php echo ($i == 1) ? 'active' : ''; ?>" 
                     id="slide-<?php echo $i; ?>">
                    <img src="<?php echo $image_url; ?>" 
                         alt="Customer Image <?php echo $i; ?>">
                    <div class="mt-2">
                        <small class="text-muted"><?php echo $filename; ?></small>
                    </div>
                </div>
            <?php 
            $i++;
            }
            ?>
            
            <div class="slider-nav">
                <button class="btn btn-sm btn-outline-primary" onclick="prevSlide()">
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
                <span id="slide-counter">1/<?php echo $filecount; ?></span>
                <button class="btn btn-sm btn-outline-primary" onclick="nextSlide()">
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    <?php } else { ?>
        <div class="text-center py-5">
            <i class="fas fa-image fa-3x text-muted mb-3"></i>
            <p class="text-muted">No customer images found</p>
        </div>
    <?php } ?>
</div>

<script>
let currentSlide = 1;
const totalSlides = <?php echo $filecount; ?>;

function showSlide(n) {
    // Hide all slides
    document.querySelectorAll('.slide').forEach(slide => {
        slide.classList.remove('active');
    });
    
    // Show the selected slide
    const slide = document.getElementById(`slide-${n}`);
    if (slide) {
        slide.classList.add('active');
    }
    
    // Update counter
    document.getElementById('slide-counter').textContent = `${n}/${totalSlides}`;
    currentSlide = n;
}

function nextSlide() {
    let next = currentSlide + 1;
    if (next > totalSlides) next = 1;
    showSlide(next);
}

function prevSlide() {
    let prev = currentSlide - 1;
    if (prev < 1) prev = totalSlides;
    showSlide(prev);
}

// Auto-advance slides every 5 seconds (optional)
setInterval(nextSlide, 5000);
</script>