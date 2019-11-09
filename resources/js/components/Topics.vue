<template>
   <div>
       <p class="Dashboard-heading">Topics</p>
       <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">SrNo</th>
      <th scope="col">Name</th>
      <th scope="col">Created At</th>
      <th scope="col">Created By</th>
      <th scope="col">Associated Events</th>
      <th scope="col">Option</th>
      
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><b>1</b></td>
      <td>Camping</td>
      <td>4 july 19</td>
      <td>Admin</td>
      <td>5</td>
      <td>
      <button class="btn btn-sm btn-link">Edit</button>
      <button class="btn btn-sm btn-danger">Delete</button>
      </td>
    </tr>
    <tr>
      <td><b>2</b></td>
      <td>Camping</td>
      <td>4 july 19</td>
      <td>Admin</td>
      <td>5</td>
      <td>
      <button class="btn btn-sm btn-link">Edit</button>
      <button class="btn btn-sm btn-danger">Delete</button>
      </td>
    </tr>
    <tr>
      <td><b>3</b></td>
      <td>Camping</td>
      <td>4 july 19</td>
      <td>Admin</td>
      <td>5</td>
      <td>
      <button class="btn btn-sm btn-link">Edit</button>
      <button class="btn btn-sm btn-danger">Delete</button>
      </td>
    </tr>
   </tbody>
</table>
   </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>