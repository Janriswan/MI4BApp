<?= $this->extend("layout/layout");
echo $this->section("content"); ?>

<div class="row">
  <div class="col-md-12">
  <table class="table table-hover">
                <tr>
                    <th>No.</th>
                    <th>Cover</th>
                    <th>Nama Film</th>
                    <th>Genre</th>
                    <th>Duration</th>
                    <th>Action</th>
                </tr>

                <?php $i = 1;
                foreach ($data_film as $film): ?>
                    <tr>
                        <td>
                            <?= $i++; ?>
                        </td>
                        <td>
                            <img src="/assets/cover/<?= $film["cover"] ?> " alt="Image" width="35px" height="50px">
                        </td>
                        <td>
                            <?= $film["nama_film"] ?>
                        </td>
                        <td>
                            <?= $film["nama_genre"] ?>
                        </td>
                        <td>
                            <?= $film["duration"] ?>
                        </td>
                        <td>
                            <a href="" class="btn btn-success">Update</a>
                            <a href="" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>
        </div>

    </div>
</div>

<!-- import JS -->
<script src="/assets/js/bootstrap.min.js"></script>



  </div>
</div>

<?= $this->endSection();?>