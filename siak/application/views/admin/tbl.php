                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th colspan="6"
                                        class="text-center">User Permissions</th>
                                </tr>
                                <tr>
                                    <th rowspan="2" class="text-center">Module Name</th>
                                    <th colspan="5" class="text-center">Permissions</th>
                                </tr>
                                <tr>
                                    <th class="text-center">View</th>
                                    <th class="text-center">Add</th>
                                    <th class="text-center">Edit</th>
                                    <th class="text-center">Delete</th>
                                    <th class="text-center">Miscellaneous</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Account Settings</td>
                                    <td class="text-center">
                                        <input type="checkbox" name="account_settings-index" <?= ($permission['account_settings-index'] == 1) ? 'checked' : '' ?>>
                                    </td>
                                    <td class="text-center">
                                    </td>
                                    <td class="text-center">
                                    </td>
                                    <td class="text-center">
                                    </td>
                                    <td>
                                        <label><input type="checkbox" name="account_settings-main" <?= ($permission['account_settings-main'] == 1) ? 'checked' : '' ?>> Account Settings - Main</label>
                                        <label><input type="checkbox" name="account_settings-cf" <?= ($permission['account_settings-cf'] == 1) ? 'checked' : '' ?>> Account Settings - Cf</label>
                                        <label><input type="checkbox" name="account_settings-email" <?= ($permission['account_settings-email'] == 1) ? 'checked' : '' ?>> Account Settings - Email</label>
                                        <label><input type="checkbox" name="account_settings-printer" <?= ($permission['account_settings-printer'] == 1) ? 'checked' : '' ?>> Account Settings - Printer</label>
                                        <label><input type="checkbox" name="account_settings-tags" <?= ($permission['account_settings-tags'] == 1) ? 'checked' : '' ?>> Account Settings - Tags</label>
                                        <label><input type="checkbox" name="account_settings-entrytypes" <?= ($permission['account_settings-entrytypes'] == 1) ? 'checked' : '' ?>> Account Settings - Entrytypes</label>
                                        <label><input type="checkbox" name="account_settings-lock" <?= ($permission['account_settings-lock'] == 1) ? 'checked' : '' ?>> Account Settings - Lock</label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Accounts</td>
                                    <td class="text-center">
                                        <input type="checkbox" name="accounts-index" <?= ($permission['accounts-index'] == 1) ? 'checked' : '' ?>>
                                    </td>
                                    <td class="text-center">
                                    </td>
                                    <td class="text-center">
                                    </td>
                                    <td class="text-center">
                                    </td>
                                    <td>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Dashboard</td>
                                    <td class="text-center">
                                        <input type="checkbox" name="dashboard-index" <?= ($permission['dashboard-index'] == 1) ? 'checked' : '' ?>>                                   
                                    </td>
                                    <td class="text-center">
                                    </td>
                                    <td class="text-center">
                                    </td>
                                    <td class="text-center">
                                    </td>
                                    <td>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Entries</td>
                                    <td class="text-center">
                                        <input type="checkbox" name="entries-view" <?= ($permission['entries-view'] == 1) ? 'checked' : '' ?>>                                    
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" name="entries-add" <?= ($permission['entries-add'] == 1) ? 'checked' : '' ?>>                                    
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" name="entries-edit" <?= ($permission['entries-edit'] == 1) ? 'checked' : '' ?>>                                    
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" name="entries-delete" <?= ($permission['entries-delete'] == 1) ? 'checked' : '' ?>>                                    
                                    </td>
                                    <td>
                                        <label><input type="checkbox" name="entries-index" <?= ($permission['entries-index'] == 1) ? 'checked' : '' ?>> Entries - Index</label>
                                        <label><input type="checkbox" name="search-index" <?= ($permission['search-index'] == 1) ? 'checked' : '' ?>> Search - Index</label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Groups</td>
                                    <td class="text-center">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" name="groups-add" <?= ($permission['groups-add'] == 1) ? 'checked' : '' ?>>                                    
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" name="groups-edit" <?= ($permission['groups-edit'] == 1) ? 'checked' : '' ?>>                                    
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" name="groups-delete" <?= ($permission['groups-delete'] == 1) ? 'checked' : '' ?>>                                    
                                    </td>
                                    <td>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Ledgers</td>
                                    <td class="text-center">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" name="ledgers-add" <?= ($permission['ledgers-add'] == 1) ? 'checked' : '' ?>>                                    
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" name="ledgers-edit" <?= ($permission['ledgers-edit'] == 1) ? 'checked' : '' ?>>                                    
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" name="ledgers-delete" <?= ($permission['ledgers-delete'] == 1) ? 'checked' : '' ?>>                                    
                                    </td>
                                    <td>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Reports</td>
                                    <td colspan="5">
                                        <span style="inline-block">
                                            <label><input type="checkbox" name="reports-balancesheet" <?= ($permission['reports-balancesheet'] == 1) ? 'checked' : '' ?>> Reports - Balance Sheet</label>
                                        </span>
                                        <span style="inline-block">
                                            <label><input type="checkbox" name="reports-profitloss" <?= ($permission['reports-profitloss'] == 1) ? 'checked' : '' ?>> Reports - Profit/Loss</label>
                                        </span>
                                        <span style="inline-block">
                                             <label><input type="checkbox" name="reports-trialbalance" <?= ($permission['reports-trialbalance'] == 1) ? 'checked' : '' ?>> Reports - Trial Balance</label>
                                        </span>
                                        <span style="inline-block">
                                            <label><input type="checkbox" name="reports-ledgerstatement" <?= ($permission['reports-ledgerstatement'] == 1) ? 'checked' : '' ?>> Reports - Ledger Statement</label>
                                        </span>
                                        <span style="inline-block">
                                            <label><input type="checkbox" name="reports-ledgerentries" <?= ($permission['reports-ledgerentries'] == 1) ? 'checked' : '' ?>> Reports - Ledger Entries</label>
                                        </span>
                                        <span style="inline-block">
                                            <label><input type="checkbox" name="reports-reconciliation" <?= ($permission['reports-reconciliation'] == 1) ? 'checked' : '' ?>> Reports - Reconciliation</label>
                                        </span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
