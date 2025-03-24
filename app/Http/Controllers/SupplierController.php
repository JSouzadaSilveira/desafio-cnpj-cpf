<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Repositories\Interfaces\SupplierRepositoryInterface;
use App\Services\BrasilApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class SupplierController extends Controller
{
    protected $repository;
    protected $brasilApiService;

    public function __construct(SupplierRepositoryInterface $repository, BrasilApiService $brasilApiService)
    {
        $this->repository = $repository;
        $this->brasilApiService = $brasilApiService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search']);
        $orderBy = $request->get('order_by', ['created_at' => 'desc']);
        $suppliers = $this->repository->all($filters, $orderBy);

        return Inertia::render('Suppliers/Index', [
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Suppliers/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Supplier::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        // If it's a CNPJ, validate with BrasilAPI
        if (strlen(preg_replace('/[^0-9]/', '', $request->document)) === 14) {
            $cnpjInfo = $this->brasilApiService->getCnpjInfo($request->document);

            if (!$cnpjInfo) {
                return back()->withErrors(['document' => 'Invalid CNPJ or CNPJ not found']);
            }
        }

        $supplier = $this->repository->create($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $supplier = $this->repository->find($id);

        if (!$supplier) {
            return redirect()->route('suppliers.index')->with('error', 'Supplier not found');
        }

        return Inertia::render('Suppliers/Show', [
            'supplier' => $supplier
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return Inertia::render('Suppliers/Edit', [
            'supplier' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $supplier = $this->repository->find($id);

        if (!$supplier) {
            return redirect()->route('suppliers.index')->with('error', 'Supplier not found');
        }

        $rules = Supplier::$rules;
        $rules['document'] = 'required|string|unique:suppliers,document,' . $id;

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        if ($this->repository->update($id, $request->all())) {
            return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
        }

        return back()->with('error', 'Failed to update supplier');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if ($this->repository->delete($id)) {
            return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
        }

        return back()->with('error', 'Failed to delete supplier');
    }

    public function findByDocument($document)
    {
        $supplier = $this->repository->findByDocument($document);

        if (!$supplier) {
            return response()->json(['error' => 'Supplier not found'], 404);
        }

        return response()->json($supplier);
    }
}
