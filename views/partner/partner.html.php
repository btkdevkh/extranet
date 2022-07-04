<section class="actors">
  <div class="wrapper">
    <div class="actors-container"> 
      <div class="show_actor">
        <article>
          <img src="<?= URL ?>public/img/<?= $partner['logo'] ?>" alt="<?= $partner['title'] ?>">
          <h3 class="actor-title"><?= $partner['title'] ?></h3>
          <p class="actor-p"><?= $partner['content'] ?></p>  
        </article>
      </div>

      <div class="actor-comments">
        <div class="actor-comment-flex-1">
          <h3 class="flex-item-1">Comments</h3>
          <div class="flex-item-2">
            <form action="<?= URL ?>vote/thumbUp" method="POST">
              <input type="hidden" name="userId" value="<?= (int)isset($userId) ? $userId : null ?>">
              <input type="hidden" name="partnerId" value="<?= (int)isset($partnerId) ? $partnerId : null ?>">
              <input type="hidden" name="like-count">
              <button type="submit" class="actor-button" name="thumb-up">
                <i class="fas fa-thumbs-up"></i><br />
                <?= count($likes) ?>
              </button>
            </form>
            
            <form action="<?= URL ?>vote/thumbDown" method="POST">
              <input type="hidden" name="userId" value="<?= (int)isset($userId) ? $userId : null ?>">
              <input type="hidden" name="partnerId" value="<?= (int)isset($partnerId) ? $partnerId : null ?>">
              <input type="hidden" name="dislike-count">
              <button type="submit" class="actor-button" name="thumb-down">
                <i class="fas fa-thumbs-down"></i><br />
                <?= count($dislikes) ?>
              </button>
            </form>
          </div>
        </div>

        <div class="post-comment">
          <form action="<?= URL ?>comment/saveComment" method="POST">
            <input type="hidden" name="userId" value="<?= (int)isset($userId) ? $userId : null ?>">
            <input type="hidden" name="partnerId" value="<?= (int)isset($partnerId) ? $partnerId : null ?>">
            <textarea name="comment" id="" cols="30" rows="10" class="commentTextarea"></textarea>
            <button type="submit" name="comment-submit">Post Comment</button>
          </form>
        </div>

        <div class="comments">
          <?php foreach($comments as $comment) : ?>
            <div>
              <p><?= $comment['dateFr'] ?></p>
              <p><?= $comment['firstName'] ?></p>
              <hr>
              <p><?= $comment['content'] ?></p>
            </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </div>
</section>
