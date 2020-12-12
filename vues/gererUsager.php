<div class="gererUsager">
    <div class="tableUsager">
        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>Courriel</th>
                <th>Nom</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($data as $cle => $usager) {
            ?>

            <tr data-id="<?php echo $usager['id'] ?>">
                <td class="SortCLASS"></td>
                <td><?php echo $usager['courriel'] ?></td>
                <td><?php echo $usager['nom']. " ". $usager['prenom'] ?></td>
                <td>
                    <!--<button value="Modifier" class="btnAdminMod" data-id="<?php //echo $usager['id'] ?>" data-courreil="<?php //echo $usager['courriel'] ?>">Modifier</button>-->
                    <button value="Supprimer" class="btnAdminSupr" data-id="<?php echo $usager['id'] ?>" data-courreil="<?php echo $usager['courriel'] ?>">Supprimer</button>
                </td>
            </tr>

            <?php
                }
            ?>
            </tbody>
        </table>
    </div>
    <div class="modale">
        <dialog id="modaleUsager"></dialog>
    </div>

    <!--Modal Start-->
    <div class="modal-container"><div id="supprimerUs"></div></div>
    <!--Modal End-->
</div>
