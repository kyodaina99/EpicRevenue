@extends('admin.shared.layout')

@section('body')
    <h1>THis is my payment method page!</h1>
    <div class="pay">
        <form method="POST" action="/admin/payment/methods/add" class="pay">
            @csrf
            <div class="paypage">
                <div class="formgroup">
                    <label for="payname">TagName:</label>
                    <input type="text" id="payname" name="payname">
                </div>
                <div class="formgroup">
                    <label for="pslug">Slug:</label>
                    <input type="text" id="pslug" name="pslug">
                </div>
                <div class="formgroup">
                    <label for="pdes">Description:</label>
                    <input type="text" id="pdes" name="pdes">
                </div>
                <div class="formgroup">
                    <label for="pmeta">Meta Title:</label>
                    <input type="text" id="pmeta" name="pmeta">
                </div>
                <div class="formgroup">
                    <label for="pmetades">Meta Description:</label>
                    <input type="text" id="pmetades" name="pmetades">
                </div>
                <button type="submit" class="mybtn">Save</button>
            </div>
        </form>
        <div class="ptable">
            <h2>My Payments</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>action</th>
                </tr>
                
                <!-- @$i = 1; -->
                @foreach($data as $li)
                    <tr class = 'payitem'>
                        <td>
                            {{""}}
                        </td>
                        <td>
                             {{$li->payname}}
                        </td>    
                        <td>
                             {{$li->pslug}}
                        </td>  
                        <td>
                        <div class="dropdown mybtng">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                Edit
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/admin/payment/methods/add">Edit</a></li>
                                <li><a class="dropdown-item" href="#">Delete</a></li>
                            </ul>
                        </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection
