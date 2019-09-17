<select name="search_sub_cat" id="search_sub_cat" class="form-control" onchange="subcat_filter(this.value)">
                                                    <option value="">Select Sub Category</option>
                                                    <?php
                                                    if (!empty($sub_cat)) {
                                                        foreach ($sub_cat as $c) {
                                                            ?>
                                                            <option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>