<div class="cellier">
     <!-- formulaire pour l'importation -->
     <form method="post" name="formImport" class="formImport">
        <label for="nbrItems">Nombre de bouteilles par page</label>
        <select name="nbrItems" id="nbrItems">
            <option>24</option>
            <option>48</option>
            <option>96</option>
        </select>
        <label for="nbrPages">Nombre de pages</label>
        <input type="number" id="inputNbrPages" name="nbrPages" min="1" max="10" id="nbrPages" value="1"/>
        
        <button type="button" id="btnImportation">Importer les bouteilles</button>
    </form>

        <div id="rapportImportation"></div>

</div>