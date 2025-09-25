<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAcademicYearRequest;
use App\Http\Requests\UpdateAcademicYearRequest;
use App\Models\AcademicYear;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AcademicYearController extends Controller
{
    public function index(Request $request): View
    {
        $years = AcademicYear::query()
            ->orderByDesc('start_date')
            ->paginate(10)
            ->withQueryString();
        return view('admin.academic_year.index', compact('years'));
    }

    public function create(): View
    {
        return view('admin.academic_year.create');
    }

    public function store(StoreAcademicYearRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            // If is_current is true, reset others
            if (!empty($data['is_current'])) {
                AcademicYear::query()->update(['is_current' => false]);
            } else {
                $data['is_current'] = false;
            }
            AcademicYear::create($data);
        });

        return redirect()->route('academic-years.index')->with('success', 'Année académique créée.');
    }

    public function edit(int $id): View
    {
        $year = AcademicYear::findOrFail($id);
        return view('admin.academic_year.edit', compact('year'));
    }

    public function update(UpdateAcademicYearRequest $request, int $id): RedirectResponse
    {
        $year = AcademicYear::findOrFail($id);
        $data = $request->validated();

        DB::transaction(function () use ($data, $year) {
            if (!empty($data['is_current'])) {
                AcademicYear::where('id', '!=', $year->id)->update(['is_current' => false]);
            } else {
                $data['is_current'] = false;
            }
            $year->update($data);
        });

        return redirect()->route('academic-years.index')->with('success', 'Année académique mise à jour.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $year = AcademicYear::findOrFail($id);
        $year->delete();
        return redirect()->route('academic-years.index')->with('success', 'Année académique supprimée.');
    }
}
