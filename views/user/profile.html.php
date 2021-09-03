<section class="presentation">
  <div class="wrapper">
    <h1 class="gerneral-title">General</h1>
    <p class="general-p">The Groupement Banque Assurance Français (GBAF) is a federation representing the 6 major French groups :</p>

    <div class="general-drawing">
        <img src="public/img/formation.png" alt="Drawing">
        <img src="public/img/protectpeople.png" alt="Drawing">
    </div>

    <ul class="gerneral-lists">
        <li>BNP Paribas</li>
        <li>BPCE</li>
        <li>Crédit Agricole</li>
        <li>Crédit Mutuel-CIC</li>
        <li>Société Générale</li>
        <li>La Banque Postale</li>
    </ul>
    
    <p class="general-p">Even though there is strong competition between these entities, they will all work
    in the same way to manage nearly 80 million accounts in the territory
    national.
    The GBAF is the representative of the banking profession and of insurers on all
    the axes of French financial regulation. Its mission is to promote
    national banking activity. It is also a privileged interlocutor of
    authorities.</p>
  </div>
</section>

<div class="wrapper"><hr></div>

<section class="actors">
  <div class="wrapper">
    <div class="actors-container"> 
      <?php foreach($partners as $partner) : ?>
        <div class="article-container">
          <article>
            <img src="public/img/<?= $partner['logo'] ?>" alt="<?= $partner['title'] ?>">
            <div class="div_title_p">
              <h3 class="actor-title"><?= $partner['title'] ?></h3>
              <p class="actor-p"><?= substr($partner['content'], 0, 200) . '...' ?></p>
            </div>
            <a class="read-more" href="index.php?controller=partner&task=getOnePartner&partnerId=<?= (int)$partner['id'] ?>">Read more</a>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section-form"></section>
