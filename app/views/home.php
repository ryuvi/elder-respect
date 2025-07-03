
<style>
.home-background {
    background-image: url('/public/assets/img/carro-cpa.jpg');
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed; /* remova se der problema */
    position: relative;
}

.hero-overlay {
    /* background-color: rgba(255,255,255,.3); */
    background-image:
        repeating-linear-gradient(45deg, rgba(255,255,255,0.01) 0, rgba(255,255,255,0.03) .75em, transparent .75em),
        repeating-linear-gradient(-45deg, rgba(255,255,255,0.01) 0, rgba(255,255,255,0.03) .75em, transparent .75em);
    background-size: 30px 30px;
    /* background-repeat: repeat; */
    position: relative;
}

.drop-shadow {
    filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.76));
}

.home-form {
    position: absolute;
    bottom: -2.5rem;
}

.home-form input,
.home-form button {
    font-size: 1.5rem;
}

</style>

<div class="container-fluid home-background d-flex mb-5">
    <div class="hero-overlay row justify-content-center align-items-center text-center w-100" style="height: 350px; backdrop-filter: blur(1px) brightness(0.5); flex: 1">
        <h2 class="text-white fs-2 drop-shadow">Aqui você encontra seu novo carro!</h2>
        <form action="/results" method="get" class="d-flex justify-content-center align-items-center home-form">
            <div class="input-group mb-3 container p-0 rounded-3 shadow-lg">
                <input type="text" class="form-control" placeholder="Pesquisar" aria-label="Recipient's username" aria-describedby="button-addon2" name="q">
                <input type="hidden" name="type" value="cars">
                <button class="btn btn-primary" type="submit" id="button-addon2">Buscar</button>
            </div>
        </form>
    </div>
</div>

<!-- Categories List (Limited on 10) -->
<?php include_once('app/views/cities/cidades.php'); ?>

<!-- Vendors List (Limited on 10) -->
<?php include_once('app/views/vendors/index.php'); ?>

<!-- Cars List (Limited on 10) -->
<?php include_once('app/views/carros/carros.php'); ?>
