$ErrorActionPreference = 'Stop'
$s = New-Object Microsoft.PowerShell.Commands.WebRequestSession
$lp = Invoke-WebRequest -Uri 'http://127.0.0.1:8000/login' -WebSession $s -UseBasicParsing
if ($lp.Content -match 'name=\"_token\" value=\"([^\"]+)\"') { $tok = $Matches[1] } else { $tok = '' }
Write-Output "CSRF_TOKEN:$tok"
$form = @{ _token=$tok; type='email'; login='admin@uinsu.ac.id'; password='password' }
$loginResp = Invoke-WebRequest -Uri 'http://127.0.0.1:8000/login' -Method POST -Body $form -WebSession $s -UseBasicParsing -MaximumRedirection 10
Write-Output ("LoginStatus:" + $loginResp.StatusCode.Value__)
# After login, request the create page
$create = Invoke-WebRequest -Uri 'http://127.0.0.1:8000/gedung/create' -WebSession $s -UseBasicParsing -Method GET
Write-Output ("CreateStatus:" + $create.StatusCode.Value__)
if ($create.Content -match 'Tambah Gedung') { Write-Output 'Found: Tambah Gedung' } else { Write-Output 'NotFound: Tambah Gedung'; Write-Output '--- Begin Create Page Snippet ---'; $snippet = $create.Content.Substring(0,[Math]::Min(1000,$create.Content.Length)); Write-Output $snippet; Write-Output '--- End Snippet ---' }
