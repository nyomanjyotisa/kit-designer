<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use DataTables;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use App\Models\Product;
use App\Models\Product_image;
use App\Models\Product_colours;

class ProductController extends Controller
{

    /**
     * Show the users dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        return view('inventory');
    }

    /**
     * Show User List
     *
     * @param Request $request
     * @return mixed
     */
    public function getProductList(Request $request): mixed
    {
        $data = Product::leftJoin('product_images', "product_images.product_id", "=", "products.id")->get();
        return view('inventory.product.list', compact('data'));
    }

    /**
     * User Create
     *
     * @return mixed
     */
    public function create(): mixed
    {
        try {
            return view('inventory.product.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store User
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {

        // echo "<pre>";
        //  print_r($request->colours);die;

        try {
            // store product information
            $product = Product::create([
                'pro_name' => $request->product_name,
                'pro_author' => $request->product_author,
                'pro_product_set' => $request->productSet,
            ]);
            // echo $product->id;

            $images = array();
            if ($request->hasfile('product-images')) {
                foreach ($request->file('product-images') as $file) {
                    $name = time() . '.' . $file->extension();
                    $file->move(public_path() . '/img/products/' . $product->id . '/', $name);
                    $images[] = $name;

                    $Save_Product_image = Product_image::create([
                        'product_id' => $product->id,
                        'product_image' => $name,
                    ]);
                }
            }

            if (!empty($request->colours)) {
                $i = 0;
                foreach ($request->colours as $colour) {
                    foreach ($colour as $colour_name) {
                        $color_image_name = "";
                        $color_file = $request->file('product_color_image')[$i][0];
                        $color_image_name = time() . '.' . $color_file->extension();
                        $color_file->move(public_path() . '/img/products/' . $product->id . '/', $color_image_name);
                        $save_product_colour = Product_colours::create([
                            'product_id' => $product->id,
                            'colour' => $colour_name,
                            'product_color_image' => $color_image_name
                        ]);
                    }
                    $i++;
                }
            }

            // Create new product success message 
            return redirect('products')->with('success', 'New Product created!');
            //     } 
            return redirect('products')->with('error', 'Failed to create new product! Try again.');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            //  print_r($bug);
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Edit User
     *
     * @param int $id
     * @return mixed
     */
    public function edit($id): mixed
    {
        try {
            $user = User::with('roles', 'permissions')->find($id);

            if ($user) {
                $user_role = $user->roles->first();
                $roles = Role::pluck('name', 'id');

                return view('user-edit', compact('user', 'user_role', 'roles'));
            }

            return redirect('404');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Update User
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        // update user info
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required | string ',
            'email' => 'required | email',
            'role' => 'required',
        ]);

        // check validation for password match
        if (isset($request->password)) {
            $validator = Validator::make($request->all(), [
                'password' => 'required | confirmed',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }

        try {
            if ($user = User::find($request->id)) {
                $payload = [
                    'name' => $request->name,
                    'email' => $request->email,
                ];
                // update password if user input a new password
                if (isset($request->password) && $request->password) {
                    $payload['password'] = $request->password;
                }

                $update = $user->update($payload);
                // sync user role
                $user->syncRoles($request->role);

                return redirect()->back()->with('success', 'User information updated succesfully!');
            }

            return redirect()->back()->with('error', 'Failed to update user! Try again.');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Delete User
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        if ($user = User::find($id)) {
            $user->delete();

            return redirect('users')->with('success', 'User removed!');
        }

        return redirect('users')->with('error', 'User not found');
    }
}
