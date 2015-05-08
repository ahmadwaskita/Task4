<table>
 <tbody>
  <tr>
   <td>Content</td>
   <td>User</td>
   <td>Created_at</td>
   <td>Updated_at</td>
  </tr>
  @foreach($comments as $comment)
  <tr>
   <td>{{$comment['content']}}</td>
   <td>{{$comment['user']}}</td>
   <td>{{$comment['created_at']}}</td>
   <td>{{$comment['updated_at']}}</td>
  </tr>
  @endforeach
 </tbody>
</table>