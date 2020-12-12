<div class="cellier">
   <div class="main-title">
       <div class="main-title-welcome">
            <h1>Panneau Admin</h1>

            <!--  -->
            <form method="post" name="formImport">
                <label for="nbrItems">Nombre de bouteilles par page</label>
                <select name="nbrItems" id="nbrItems">
                        <option>24</option>
                        <option>48</option>
                        <option>96</option>
                </select>
                <label for="nbrPages">Nombre de pages</label>
                <input type="number" name="nbrPages" min="1" max="5" id="nbrPages" value="1"/>
                <!--  -->
                <div class="main-title-call-action">
                    <button type="button" class="btn-call-action" id="btnImportation">Importer les bouteilles</button>
                </div>  
            </form>

              
       </div>
       
       <div id="rapportImportation"></div>
    </div>

</div>