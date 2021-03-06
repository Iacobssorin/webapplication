<?php
  
    if ( !isset($database_link))
    {
        die(header('location: index.php?page=news'));
    }

    if ( !isset($_GET['category_id']))
    {
        die(header('location: index.php'));
    }

    $category_id = ($_GET['category_id'] * 1);
?>

<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th colspan="2" ><a href="index.php?page=news&amp;action=add&amp;category_id=<?php echo $category_id; ?>" class="btn btn-success btn-xs" title="Creeaza"><i class="icon-plus"></i> Creeaza</a></th>
			<th>Id</th>
			<th>Titlu</th>
			<th>Autor</th>
			<th>Data</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th colspan="6"><a href="index.php?page=news&amp;action=add&amp;category_id=<?php echo $category_id; ?>" class="btn btn-success btn-xs" title="Creeaza"><i class="icon-plus"></i> Creeaza</a></th>
		</tr>
	</tfoot>
	<tbody>
		<?php
            $query = "	SELECT news_id, news_title, news_content, news_postdate, user_name 
            			FROM news
            			INNER JOIN users ON users.user_id = news.fk_users_id
            			WHERE fk_categories_id = $category_id
            			ORDER BY news_postdate DESC";
            $result = mysqli_query($database_link, $query) or if_sql_error_then_die(mysqli_error($database_link), $query, __LINE__, __FILE__);
            if (mysqli_num_rows($result) > 0)
            {
                
                while ($row = mysqli_fetch_assoc($result))
                {
                    echo '
			            <tr>
			                <td style="width:30px;">
			                	<a 	href="index.php?page=news&amp;action=edit&amp;news_id='.$row['news_id'].'&amp;category_id='.$category_id.'" 
			            			class="btn btn-primary btn-xs" 
			            			title="Editeaza">
			            				<i class="icon-pencil"></i>
			    				</a>
							</td>
			                <td style="width:30px;">
			                	<a 	href="index.php?page=news&amp;action=delete&amp;news_id='.$row['news_id'].'&amp;category_id='.$category_id.'" 
			                		class="btn btn-danger btn-xs" 
			                		title="Sterge" 
			                		onclick="return confirm(\'Sigur doriți să ștergeți?\')">
			                			<i class="icon-trash"></i>
			        			</a>
			    			</td>
			                <td style="width:50px;">'.$row['news_id'].'</td>
			                <td>'.$row['news_title'].'</td>
			                <td>'.$row['user_name'].'</td>
			                <td>'.$row['news_postdate'].'</td>
			            </tr>';
                }

            }
            else
            {
                echo '<tr><td colspan="6">Nu au fost create nici o postare</td></tr>';
            }
		?>
	</tbody>
</table>

