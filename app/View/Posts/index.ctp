
<h1>Blog posts</h1>

<!-- create add link by controller is posts view is add  -->
<?php echo $this->Html->link(
    'Add Post',
    array('controller' => 'posts', 'action' => 'add')
); ?>
<table>
    <!--topic of row table -->
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Action</th>
        <th>Created</th>
    </tr>

    <?php foreach ($posts as $post): ?><!-- loop for show data -->
    <tr>
        <td><?php echo $post['Post']['id']; ?></td><!-- show id  -->

        <td>
            <!-- show title -->
            <?php
                //create title link that controller is posts view is $post['Post']['id']
                 echo $this->Html->link(
                    $post['Post']['title'],
                     array('controller' => 'posts', 'action' => 'view', $post['Post']['id']
                     )); 
            ?>
        </td>

        <td>
            <!-- goto delete -->
            <?php
                echo $this->Form->postLink(
                    'Delete',
                    array('action' => 'delete', $post['Post']['id']),
                    array('confirm' => 'Are you sure?')
                );
            ?>

            <!-- goto edit -->
            <?php
                echo $this->Html->link(
                    'Edit',
                    array('controller' => 'posts','action' => 'edit', $post['Post']['id'])
                );
            ?>
        </td>

        <td><?php echo $post['Post']['created']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($post); ?>
</table>