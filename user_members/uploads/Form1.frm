VERSION 5.00
Begin VB.Form Form1 
   Caption         =   "Form1"
   ClientHeight    =   4050
   ClientLeft      =   60
   ClientTop       =   405
   ClientWidth     =   9495
   LinkTopic       =   "Form1"
   ScaleHeight     =   4050
   ScaleWidth      =   9495
   StartUpPosition =   3  'Windows Default
   Begin VB.CommandButton Command1 
      Caption         =   "Login"
      Height          =   495
      Left            =   2280
      TabIndex        =   4
      Top             =   2520
      Width           =   1215
   End
   Begin VB.TextBox Text2 
      Height          =   495
      Left            =   2040
      TabIndex        =   3
      Top             =   1200
      Width           =   2175
   End
   Begin VB.TextBox Text1 
      Height          =   495
      Left            =   2040
      TabIndex        =   2
      Top             =   600
      Width           =   2175
   End
   Begin VB.Label Label2 
      Caption         =   "password"
      Height          =   495
      Left            =   1080
      TabIndex        =   1
      Top             =   1320
      Width           =   1215
   End
   Begin VB.Label Label1 
      Caption         =   "username"
      Height          =   495
      Left            =   1080
      TabIndex        =   0
      Top             =   720
      Width           =   1215
   End
End
Attribute VB_Name = "Form1"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = False
Dim x As Integer


Private Sub Command1_Click()
If Text1.Text = "darwin" And Text2.Text = "wengweng" Then
Form2.Show
Form1.Hide
Else
If x = 0 Then
MsgBox "2 attempts remaining"
Text1.Text = ""
Text2.Text = ""
x = x + 2
Else
If x = 2 Then
MsgBox "Last attempt remaining"
Text1.Text = ""
Text2.Text = ""
x = x + 2
Else
If x = 4 Then
MsgBox "Program Terminated"
End
End If
End If
End If
End If

End Sub

Private Sub Form_Load()

MsgBox "Welcome to program!"
End Sub
