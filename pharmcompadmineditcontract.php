<td>
                    <form action="pharmcom_edit_contract.php" method="POST">
                        <input type="hidden" name="contract_ID" value="<?php echo $row['contract_ID']; ?>">
                        <input type="submit" value="Edit">
                    </form>
                    <form action="pharmcom_update_contract.php" method="POST">
                        <input type="hidden" name="contract_ID" value="<?php echo $row['contract_ID']; ?>">
                        <input type="submit" value="Update">
                    </form>
                    
                </td>