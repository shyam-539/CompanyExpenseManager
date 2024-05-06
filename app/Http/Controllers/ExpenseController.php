<?php

namespace App\Http\Controllers;


use App\Models\Expense;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\ExpenseRequest;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all expenses from the database
        $expenses = Expense::where('user_id', auth()->id())->simplePaginate(4);


        // Fetch list of categories
        $categories = Category::all();

        // Pass the expenses to the view
        return view('user.expenses.list', [

            'categories' => $categories,
            'expenses' => $expenses

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch list of users
        $users = User::all();

        // Fetch list of categories
        $categories = Category::all();

        // Pass both lists to the view
        return view('user.expenses.create', ['categories' => $categories, 'users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseRequest $request)
    {
       

        // Create the expense using create method
        $expense = Expense::create([
            'user_id' => auth()->id(),
            'category_id' => $request['category_id'],
            'amount' => $request['amount'],
            'tax_percentage' => $request['tax_percentage'],
            'net_amount' => $request['net_amount'],
        ]);

        // Handle image upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store(config('app.path') . $expense->user_id, 'public'); // Store images in /uploads/invoices/user_id folder
                $expense->images()->create(['image' => $path]);
            }

        }

        // Redirect back with success message
        return redirect()->route('expenses.index')->with('success', 'Expense created successfully.');
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Fetch the specific expense from the database
        $expense = Expense::findOrFail($id);

        // Pass the expense details to the view
        return view('user.expenses.show', [
            'expense' => $expense,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $expense = Expense::findOrFail($id);
        $categories = Category::all();
        return view('user.expenses.edit', [
            'expense' => $expense,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseRequest $request, string $id)
    {
        // Validate the request data using the rules method

        $expense = Expense::findOrFail($id);

        try {
            $expense->category_id = $request->category_id;
            $expense->amount = $request->amount;
            $expense->tax_percentage = $request->tax_percentage;
            $expense->tax_amount = $request->tax_amount;
            $expense->net_amount = $request->net_amount;

            // Retrieve paths of existing images
            $existingImages = $expense->images()->pluck('image')->toArray();

            // Delete all existing images associated with the expense
            $expense->images()->delete();

            // Delete existing images from storage
            foreach ($existingImages as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }



            // Handle image upload
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store(config('app.path') . $expense->user_id, 'public'); // Store images in /uploads/invoices/user_id folder
                    $expense->images()->create(['image' => $path]);
                }
            }

            // Save the updated expense
            $expense->save();

            // Redirect back with success message
            return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
        } catch (\Exception $e) {
            // Handle any exceptions
            return redirect()->route('expenses.index')->with('error', 'Failed to update expense. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {

        $expense->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }

    /**
     * Filter the specified data from DB and to show it.
     */
    public function filter(Request $request)
    {
        $query = Expense::where('user_id', auth()->id());

        $categories = Category::all();

        // Apply category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Apply date filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Apply duration filter
        if ($request->filled('duration')) {
            $duration = $request->duration;
            $query->whereDate('created_at', '>=', now()->subDays($duration));
        }

        // Apply month filter
        if ($request->filled('month')) {
            $month = $request->month;
            $query->whereMonth('created_at', $month);
        }

        // Fetch filtered expenses
        $filteredExpenses = $query->get();

        // Calculate total expense
        $totalExpense = $filteredExpenses->sum('amount');

        // Pass the filtered expenses and total expense to the view
        return view('user.expenses.filtered_expenses', [
            'categories' => $categories,
            'expenses' => $filteredExpenses,
            'totalExpense' => $totalExpense,
        ]);
    }
}
