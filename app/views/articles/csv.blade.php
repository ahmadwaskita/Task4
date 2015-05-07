<table>
 <tbody>
  <tr>
   <td>Created At</td>
   <td>Name</td>
   <td>Email</td>
  </tr>
  @foreach($users as $user)
  <tr>
   <td>{{$user['created_at']}}</td>
   <td>{{$user['title']}}</td>
   <td>{{$user['content']}}</td>
  </tr>
  @endforeach
 </tbody>
</table>