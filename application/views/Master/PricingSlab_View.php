<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu, $this->session);
$this->pweb->menu($this->Menu, $this->session);
$this->pweb->Cheader('Master', 'PricingSlab');
?>

<div class="container-fluid mt-4">

    <!-- Header with Add Button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Pricing Slab List</h4>
        <a href="<?php echo scs_index ?>Master/PricingSlab" class="btn btn-primary">
            <i class="fa fa-plus"></i> Add New Slab
        </a>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Slab ID</th>
                            <th>Slab Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $slbqry = "select * from pricingslab_mas mas
                                         ";
                        
                        $slabs = $this->db->query($slbqry)->result_array();
                        ?>
                        <?php if (!empty($slabs)) {
                            foreach ($slabs as $row) { ?>
                                <tr>
                                    <td><?php echo $row['psid']; ?></td>
                                    <td><?php echo $row['slabname']; ?></td>
                                    <td>
                                        <a href="<?php echo scs_index ?>Master/SlabEdit/<?php echo $row['psid'] ?>" class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a href="<?php echo scs_index ?>Master/delete/' . $row['psid']" class="btn btn-sm btn-danger" onclick="return confirm('Delete this slab?')">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">No pricing slabs found.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>
