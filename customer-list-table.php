<?php
/**
 * PART 1. Defining Custom Table List
 * ============================================================================
 */

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}


/**
 * Custom_Table_Example_List_Table class that will display our custom table
 * records in nice table
 */
class Custom_List_Table1_All_Data extends WP_List_Table
{
    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'customer',
            'plural' => 'customers',
        ));
    }

    /**
     * [REQUIRED] this is a default column renderer
     *
     * @param $item - row (key, value array)
     * @param $column_name - string (key)
     * @return HTML
     */
    function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'customer_name':
            case 'customer_email':
            case 'customer_phone':
            case 'company':
            case 'designation':
            case 'interest':
            case 'business_type':
            case 'website':
            case 'contact_person':
                return $item[$column_name];
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

    /**
     * [OPTIONAL] this is example, how to render specific column
     *
     * method name must be like this: "column_[column_name]"
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_age($item)
    {
        return '<em>' . $item['customer_name'] . '</em>';
    }

    /**
     * [OPTIONAL] this is example, how to render column with actions,
     * when you hover row "Edit | Delete" links showed
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_name($item)
    {
        // links going to /admin.php?page=[your_plugin_page][&other_params]
        // notice how we used $_REQUEST['page'], so action will be done on curren page
        // also notice how we use $this->_args['singular'] so in this example it will
        // be something like &person=2
        $actions = array(
            'edit' => sprintf('<a href="?page=single-customer&id=%s">%s</a>', $item['id'], __('View', 'cltd_example')),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s" onClick="return confirm(\'Are you sure?\')">%s</a>', $_REQUEST['page'], $item['id'], __('Delete', 'cltd_example')),
        );

        return sprintf('%s %s',
            $item['customer_name'],
            $this->row_actions($actions)
        );
    }

    /**
     * [REQUIRED] this is how checkbox column renders
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />',
            $item['id']
        );
    }

    /**
     * [REQUIRED] This method return columns to display in table
     * you can skip columns that you do not want to show
     * like content, or description
     *
     * @return array
     */
    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'name' => __('Name', 'cltd_example'),
            'customer_email' => __('E-Mail', 'cltd_example'),
            'customer_phone' => __('Phone', 'cltd_example'),
            'company' => __('Company', 'cltd_example'),
            'designation' => __('Designation', 'cltd_example'),
            'interest' => __('Interest', 'cltd_example'),
            'business_type' => __('Business Type', 'cltd_example'),
            'website' => __('Website', 'cltd_example'),
            'contact_person' => __('Contact Person', 'cltd_example'),
        );
        return $columns;
    }

    /**
     * [OPTIONAL] This method return columns that may be used to sort table
     * all strings in array - is column names
     * notice that true on name column means that its default sort
     *
     * @return array
     */
    function get_sortable_columns()
    {
        $sortable_columns = array(
            'customer_name' => array('customer_name', false),
            'customer_email' => array('customer_email', false),
            'customer_phone' => array('customer_phone', false),
            'company' => array('company', false),
            'designation' => array('designation', false),
            'interest' => array('interest', false),
            'business_type' => array('business_type', false),
            'website' => array('website', false),
            'contact_person' => array('contact_person', false),
        );
        return $sortable_columns;
    }

    /**
     * [OPTIONAL] Return array of bult actions if has any
     *
     * @return array
     */
    function get_bulk_actions()
    {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }

    /**
     * [OPTIONAL] This method processes bulk actions
     * it can be outside of class
     * it can not use wp_redirect coz there is output already
     * in this example we are processing delete action
     * message about successful deletion will be shown on page in next part
     */
    function process_bulk_action()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'customer_data'; // do not forget about tables prefix

        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
            }
        }
    }


    function extra_tablenav($which)
    {
        global $wpdb, $testiURL, $tablename, $tablet;
        $move_on_url = '&cat-filter=';
        if ($which == "top") {
            ?>
            <div class="alignleft actions bulkactions">
                <?php
                $cats = $wpdb->get_results('select * from ' . $tablename . ' order by title asc', ARRAY_A);
                if ($cats) {
                    ?>
                    <select name="cat-filter" class="ewc-filter-cat">
                        <option value="">Filter by Category</option>
                        <?php
                        foreach ($cats as $cat) {
                            $selected = '';
                            if ($_GET['cat-filter'] == $cat['id']) {
                                $selected = ' selected = "selected"';
                            }
                            $has_testis = false;
                            $chk_testis = $wpdb->get_row("select id from " . $tablet . " where banner_id=" . $cat['id'], ARRAY_A);
                            if ($chk_testis['id'] > 0) {
                                ?>
                                <option value="<?php echo $move_on_url . $cat['id']; ?>" <?php echo $selected; ?>><?php echo $cat['title']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        if ($which == "bottom") {
            //The code that goes after the table is there

        }
    }

    /**
     * [REQUIRED] This is the most important method
     *
     * It will get rows from database and prepare them to be showed in table
     */
    function prepare_items()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'customer_data'; // do not forget about tables prefix

        $per_page = 15; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();

        // will be used in pagination settings

        if (isset($_REQUEST['page'])) {
            $sql = "SELECT COUNT(id) FROM $table_name";
        }
        $total_items = $wpdb->get_var($sql);

        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

        // [REQUIRED] define $items array
        // notice that last argument is ARRAY_A, so we will retrieve array
        if (isset($_REQUEST['page'])) {
            $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
        }

        // [REQUIRED] configure pagination
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }
}


/**
 * List page handler
 *
 * This function renders our custom table
 * Notice how we display message about successfull deletion
 * Actualy this is very easy, and you can add as many features
 * as you want.
 *
 * Look into /wp-admin/includes/class-wp-*-list-table.php for examples
 */


function cloudly_customers_list()
{
    global $wpdb;

    $table = new Custom_List_Table1_All_Data();
    $table->prepare_items();

    $message = '';
    if ('delete' === $table->current_action()) {
        $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'cltd_example'), count($_REQUEST['id'])) . '</p></div>';
    }
    ?>
    <div class="wrap">

        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2><?php _e('Customers', 'cltd_example') ?>
        <a href="http://localhost/wp-test/wp-admin/admin-ajax.php?action=csv_pull">Export to Excel</a>
        </h2>
        <?php echo $message; ?>

        <form id="persons-table" method="GET">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
            <?php $table->display() ?>
        </form>

    </div>
    <?php
}