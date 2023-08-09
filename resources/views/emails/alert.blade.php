<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
</head>
<body>
<p>Hi</p>
<p>We would like to inform you that we have found few alert and alarms for below mentioned devices</p>

<table>
  <tr>
    <th></th>
    <th>Installation</th>
    <th>Notification Type</th>
    <th>Angle</th>
    <th>Distance</th>
    <th>Address</th>
    <th>Triggered</th>
  </tr>
  @foreach( $mailData as $key => $data )
  <tr>
    <td>{{ $key }}<td>
    <td>{{ $data[$key]->installation }}</td>
    <td>{{ $data[$key]->notification_type }}</td>
    <td>{{ $data[$key]->angle_value }}</td>
    <td>{{ $data[$key]->distance_value }}</td>
    <td>{{ $data[$key]->address }}</td>
    <td>1 day ago</td>
  </tr>
  @endforeach
</table>

</body>
</html>

