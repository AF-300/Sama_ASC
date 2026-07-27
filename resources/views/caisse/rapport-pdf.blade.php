<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #14231C; }
        h1 { font-size: 20px; color: #1B5E3C; margin-bottom: 0; }
        .sous-titre { color: #6B7280; font-size: 11px; margin-top: 4px; margin-bottom: 20px; }
        .bloc-resume { display: table; width: 100%; margin-bottom: 20px; }
        .carte { display: table-cell; width: 33%; padding: 10px; border: 1px solid #E5E7EB; }
        .carte .label { font-size: 10px; color: #6B7280; }
        .carte .montant { font-size: 16px; font-weight: bold; margin-top: 4px; }
        .vert { color: #1B5E3C; }
        .rouge { color: #C1432B; }
        .or { color: #E3A83B; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #F9FAFB; text-align: left; padding: 6px 8px; font-size: 10px; text-transform: uppercase; color: #6B7280; border-bottom: 1px solid #E5E7EB; }
        td { padding: 6px 8px; font-size: 11px; border-bottom: 1px solid #F3F4F6; }
        h2 { font-size: 14px; color: #14231C; margin-top: 25px; margin-bottom: 8px; }
        .pied { margin-top: 30px; font-size: 9px; color: #9CA3AF; text-align: center; }
    </style>
</head>
<body>
    <h1>Rapport financier - Sama ASC</h1>
    <p class="sous-titre">Genere le {{ now()->format('d/m/Y a H:i') }}</p>

    <div class="bloc-resume">
        <div class="carte">
            <div class="label">TOTAL COTISATIONS</div>
            <div class="montant vert">{{ number_format($totalCotisations, 0, ',', ' ') }} FCFA</div>
        </div>
        <div class="carte">
            <div class="label">TOTAL DEPENSES</div>
            <div class="montant rouge">{{ number_format($totalDepenses, 0, ',', ' ') }} FCFA</div>
        </div>
        <div class="carte">
            <div class="label">SOLDE</div>
            <div class="montant {{ $solde >= 0 ? 'or' : 'rouge' }}">{{ number_format($solde, 0, ',', ' ') }} FCFA</div>
        </div>
    </div>

    <h2>Cotisations par quartier</h2>
    <table>
        <thead>
            <tr><th>Quartier</th><th style="text-align: right;">Montant</th></tr>
        </thead>
        <tbody>
            @forelse ($cotisationsParQuartier as $quartier => $total)
                <tr><td>{{ $quartier }}</td><td style="text-align: right;">{{ number_format($total, 0, ',', ' ') }} FCFA</td></tr>
            @empty
                <tr><td colspan="2">Aucune contribution enregistree.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Depenses par categorie</h2>
    <table>
        <thead>
            <tr><th>Categorie</th><th style="text-align: right;">Montant</th></tr>
        </thead>
        <tbody>
            @forelse ($depensesParCategorie as $categorie => $total)
                <tr><td style="text-transform: capitalize;">{{ $categorie }}</td><td style="text-align: right;">{{ number_format($total, 0, ',', ' ') }} FCFA</td></tr>
            @empty
                <tr><td colspan="2">Aucune depense enregistree.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Detail des cotisations payees</h2>
    <table>
        <thead>
            <tr><th>Contributeur</th><th>Quartier</th><th>Periode</th><th style="text-align: right;">Montant</th></tr>
        </thead>
        <tbody>
            @forelse ($toutesCotisations as $cotisation)
                <tr>
                    <td>{{ $cotisation->contributeur->prenom }} {{ $cotisation->contributeur->nom }}</td>
                    <td>{{ $cotisation->contributeur->quartier }}</td>
                    <td>{{ $cotisation->periode }}</td>
                    <td style="text-align: right;">{{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA</td>
                </tr>
            @empty
                <tr><td colspan="4">Aucune cotisation.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Detail des depenses</h2>
    <table>
        <thead>
            <tr><th>Date</th><th>Libelle</th><th>Categorie</th><th style="text-align: right;">Montant</th></tr>
        </thead>
        <tbody>
            @forelse ($toutesDepenses as $depense)
                <tr>
                    <td>{{ $depense->date_depense->format('d/m/Y') }}</td>
                    <td>{{ $depense->libelle }}</td>
                    <td style="text-transform: capitalize;">{{ $depense->categorie }}</td>
                    <td style="text-align: right;">{{ number_format($depense->montant, 0, ',', ' ') }} FCFA</td>
                </tr>
            @empty
                <tr><td colspan="4">Aucune depense.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p class="pied">Sama ASC - Document genere automatiquement</p>
</body>
</html>