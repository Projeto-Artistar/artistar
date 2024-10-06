<?= $this->layout("base", [
    'title' => $title, 
    'header' => $header,
    'footer' => $footer
    ]
); ?>

<?= $this->start("css") ?>
<link rel="stylesheet" href="<?= url("assets/css/results.css") ?>">
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>
<section class="container minimum-height">
    <div class="row avoid-navbar">
        <div class="col-6">
            <span class="h1"><?= $_GET['search'] ?></span>
        </div>
        <div class="col-6 d-flex justify-content-end align-items-end">
            <p class="h4"><span class="color-klikit-2">200</span> Resultados</p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2 col-md-3 col-sm-4 col-12">
            <div class="row">
                <hr>
                <div class="col-12 py-1">
                    <div class="form-group">
                        <label for="filterRegion">Região</label>
                        <select id="filterRegion" class="form-control input-kiklit-2 my-1" name="r">
                            <option value="">Selecione uma região</option>
                            <?php foreach($estados as $estado) {?>
                                <option <?php if($estado['uf'] == $get['r']) echo 'selected'; ?> value="<?= $estado['uf'] ?>"><?= $estado['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-12 py-1">
                    <div class="form-group">
                        <label for="filterCity">Cidade</label>
                        <select id="filterCity" class="form-control input-kiklit-2 my-1" name="c">
                            <option value="<?php if (!empty($get['c'])) echo $get['c']; ?>"><?= empty($get['c']) ? 'Selecione uma cidade' : $get['c']; ?></option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="col-12 py-1">
                    <p class="h3">Eventos</p>
                </div>
                <div class="col-12 py-1">
                    <div class="form-group">
                        <label for="filterDate">Data Inicial</label>
                        <input type="date" id="filterDate" class="form-control input-kiklit-2 my-1" name="sd" value="<?= $get['sd']?>">
                    </div>
                </div>
                <div class="col-12 py-1">
                    <div class="form-group">
                        <label for="filterDate">Data Final</label>
                        <input type="date" id="filterDate" class="form-control input-kiklit-2 my-1" name="fd" value="<?= $get['fd']?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="row col-lg-10 col-md-9 col-sm-8 col-12">
            <?php foreach($results as $result) {
                switch($result['type']){
                    case 'event':
            ?>
            <a class="col-lg-4 col-md-6 col-12 mb-4 evento" href="/events/<?= $result['id'] ?>/<?= $result['url']?>">
                <div class="card">
                    <img class="card-img-top" src="<?= $result['image']?>" alt="Card image cap">
                    <span class="image-overlay"><?= $result['start_date']?> - <?= $result['start_date']?></span>
                    <div class="card-body">
                        <h5 class="card-title"><?= $result['title']?></h5>
                        <p class="card-text descricao-evento"><?= $result['subtitle']?></p>
                    </div>
                </div>
            </a>

            <?php
                        break;
                    case 'exhibitor':          
            ?>
            <a class="col-lg-4 col-md-6 col-12 mb-4 evento" href="/events/<?= $result['id'] ?>/<?= $result['url']?>">
                <div class="card">
                    <div class="card-img-top d-flex justify-content-center align-items-center" style="height: 200px;">
                        <img class="rounded-circle" src="<?= $result['image']?>" alt="Card image cap" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= $result['title']?></h5>
                        <p class="card-text">@</p>
                        <p class="card-text descricao-evento"><?= $result['subtitle']?></p>
                    </div>
                </div>
            </a>
            <?php
                        break;
                    case 'productor':
                        echo 'Um produtor<br>';
                        break;
                }
            
            } ?>
        </div>
    </div>
</section>

<?= $this->stop() ?>

<?= $this->start("js") ?>
<script>
async function searchCities(uf) {
    var select = document.getElementById('filterCity');
    select.innerHTML = `<option value="${defaultCity}">${defaultCity}</option>`;
    $.ajax({
        url: '/apis/cities',
        type: 'POST',
        data: {uf: uf},
        success: async function(response) {
            response = JSON.parse(response);
            if (response.code == 200) {
                cities = response.data.cities;
                select.innerHTML = '<option value="">Selecione uma cidade</option>';
                cities.forEach(city => {
                    
                    var option = document.createElement('option');
                    //selected if city is the same as the one selected
                    if (city.nome == defaultCity) {
                        option.selected = true;
                    }
                    option.value = city.nome;
                    option.text = city.nome;
                    select.appendChild(option);
                });
            }
        },
        error: async function(error) {
            console.log('An error occurred');
        }
    });
}

document.getElementById('filterRegion').addEventListener('change', async function() {
    var uf = this.value;
    searchCities(uf); 
});

const defaultCity = '<?= empty($get['c']) ? 'Carregando...' : $get['c']; ?>';
    searchCities('<?= empty($get['r']) ? '' : $get['r']; ?>');
</script>
<?= $this->stop() ?>