<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
    global $wpdb;

    if( ! empty( $_GET ) && isset( $_GET['as_em_search'] ) ) {
        $search_results = as_em_search( $_GET['as_em_search'] );
    } else {
        $search_results = null;
    }
?>
<div>Search</div>
<form method="get">
    <input type="hidden" name="post_type" value="<?php echo EM_POST_TYPE_EVENT;?>">
    <input type="hidden" name="page" value="events-manager-search-form">
    <input type="text" name="as_em_search" value>
    <button type="submit">Search</button>
</form>

<div>
    <?php if( null != $search_results ): ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>City</th>
                    <th>Phone</th>
                    <th>Spaces</th>
                </tr>
            </thead>
            <tbody>
            <?php $event_id = -1; ?>
            <?php foreach( $search_results as $result ): ?>
                <?php
                    $meta = maybe_unserialize( $result->booking_meta );
                    $meta = $meta['registration'];
                ?>
                <?php if( $event_id != $result->event_id ):?>
                    <?php
                        $event_id = $result->event_id;
                        $event_name = as_em_get_event_name( $event_id );
                    ?>
                    <tr>
                        <td colspan="5"><?php echo $event_name;?></td>
                    </tr>
                <?php endif;?>
                <tr>
                    <td>
                        <a href="edit.php?post_type=<?php echo EM_POST_TYPE_EVENT;?>&page=events-manager-bookings&event_id=<?php echo $event_id;?>&booking_id=<?php echo $result->booking_id;?>">
                        <?php
                            if( isset( $meta['last_name'] ) ) {
                                echo $meta['last_name'] . ' ' .  $meta['first_name'];
                            } else {
                                echo $meta['user_name'];
                            }
                        ?>
                        </a>
                    </td>
                    <td>
                        <?php echo $meta['user_email'];?>
                    </td>
                    <td>
                        <?php echo $meta['dbem_city'];?>
                    </td>
                    <td>
                        <?php echo $meta['dbem_phone'];?>
                    </td>
                    <td>
                        <?php echo $result->booking_spaces;?>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    <?php endif; ?>
</div>