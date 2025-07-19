<?php
include_once 'functions/connection.php';

$sql = 'SELECT r.*, GROUP_CONCAT(ri.image_path) as images 
        FROM `rooms` r 
        LEFT JOIN `room_images` ri ON r.id = ri.room_id 
        GROUP BY r.id';
$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();

foreach ($results as $row) {
    $images = !empty($row['images']) ? explode(',', $row['images']) : array();
?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td>
            <?php if (!empty($images)): ?>
                <div class="d-flex">
                    <?php foreach ($images as $image): ?>
                        <img class="rounded me-2" width="30" height="30" src="functions/<?=$image?>" style="object-fit: cover;">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </td>
        <td><?php echo $row['pax']; ?></td>
        <td>₱<?php echo number_format($row['rent'], 2); ?></td>
        <td>
            <?php if ($row['is_available'] == 1): ?>
                <span class="badge bg-success">Yes</span>
            <?php else: ?>
                <span class="badge bg-primary">No</span>
            <?php endif; ?>
        </td>
        <td class="text-center">
            <button class="btn btn-warning mx-1" type="button" data-bs-target="#update" data-bs-toggle="modal" data-id="<?php echo $row['id'] ?>" data-pax="<?php echo $row['pax'] ?>" data-rent="<?php echo $row['rent'] ?>">Update</button>
            <button class="btn btn-danger mx-1" type="button" data-bs-target="#remove" data-bs-toggle="modal" data-id="<?php echo $row['id'] ?>">Remove</button>
        </td>
    </tr>

<?php
}
