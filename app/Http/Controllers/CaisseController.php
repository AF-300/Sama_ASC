<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use App\Models\Depense;

class CaisseController extends Controller
{
    public function index()
    {
        $totalCotisations = Cotisation::where('statut', 'paye')->sum('montant');
        $totalDepenses = Depense::sum('montant');
        $solde = $totalCotisations - $totalDepenses;

        $depensesParCategorie = Depense::selectRaw('categorie, SUM(montant) as total')
            ->groupBy('categorie')
            ->pluck('total', 'categorie');

            $cotisationsParQuartier = Cotisation::join('contributeurs', 'cotisations.contributeur_id', '=', 'contributeurs.id')
    ->where('cotisations.statut', 'paye')
    ->selectRaw('contributeurs.quartier, SUM(cotisations.montant) as total')
    ->groupBy('contributeurs.quartier')
    ->orderByDesc('total')
    ->pluck('total', 'quartier');

       $dernieresCotisations = Cotisation::with('contributeur')
    ->where('statut', 'paye')
    ->orderByDesc('date_paiement')
    ->limit(5)
    ->get();

        $dernieresDepenses = Depense::orderByDesc('date_depense')->limit(5)->get();

        return view('caisse.index', compact(
    'totalCotisations',
    'totalDepenses',
    'solde',
    'depensesParCategorie',
    'cotisationsParQuartier',
    'dernieresCotisations',
    'dernieresDepenses'
));
    }

    public function exporterPdf()
{
    $totalCotisations = \App\Models\Cotisation::where('statut', 'paye')->sum('montant');
    $totalDepenses = \App\Models\Depense::sum('montant');
    $solde = $totalCotisations - $totalDepenses;

    $cotisationsParQuartier = \App\Models\Cotisation::join('contributeurs', 'cotisations.contributeur_id', '=', 'contributeurs.id')
        ->where('cotisations.statut', 'paye')
        ->selectRaw('contributeurs.quartier, SUM(cotisations.montant) as total')
        ->groupBy('contributeurs.quartier')
        ->orderByDesc('total')
        ->pluck('total', 'quartier');

    $depensesParCategorie = \App\Models\Depense::selectRaw('categorie, SUM(montant) as total')
        ->groupBy('categorie')
        ->pluck('total', 'categorie');

    $toutesCotisations = \App\Models\Cotisation::with('contributeur')
        ->where('statut', 'paye')
        ->orderByDesc('date_paiement')
        ->get();

    $toutesDepenses = \App\Models\Depense::orderByDesc('date_depense')->get();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('caisse.rapport-pdf', compact(
        'totalCotisations',
        'totalDepenses',
        'solde',
        'cotisationsParQuartier',
        'depensesParCategorie',
        'toutesCotisations',
        'toutesDepenses'
    ));

    return $pdf->download('rapport-financier-sama-asc-'.now()->format('Y-m-d').'.pdf');
}
}